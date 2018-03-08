<?php
/**
 * Created by PhpStorm.
 * User: cerynna
 * Date: 07/03/18
 * Time: 22:10
 */

namespace Entity;

require('OpenGraph.php');


class Link
{

    /** @var  string
     */
    public $name;
    /**
     * @var string
     */
    public $url;
    /**
     * @var string
     */
    public $meta;
    /**
     * @var array
     */
    public $tag;
    /**
     * @var string
     */
    public $slug;

    public function __construct($url)
    {
        $this->url = $url;

        $graph = \OpenGraph::fetch($url);
        if ($graph !== false) {
            $meta = $graph->getValues();
            $this->name = $meta['title'];
            if (empty($meta["meta"]["image"])) {
                $meta["meta"]["image"] =  $this->setImage($meta["link"]);
            }
            $this->meta = $meta;

            $this->slug = substr($this->slugify($meta['title']), 0, 20);
            $pureTags = explode(" ", $meta['description']);
            $arrTag = [];
            foreach ($pureTags as $solotag) {
                if (strlen($solotag) >= 3) {
                    array_push($arrTag, strtolower($solotag));
                }
            }

            $this->tag = $arrTag;
        } else {
            $this->name = $url;
        }

    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getMeta(): string
    {
        return $this->meta;
    }

    /**
     * @param string $meta
     */
    public function setMeta(string $meta)
    {
        $this->meta = $meta;
    }

    /**
     * @return array
     */
    public function getTag(): array
    {
        return $this->tag;
    }

    /**
     * @param array $tag
     */
    public function setTag(array $tag)
    {
        $this->tag = $tag;
    }


    public function getArray()
    {
        $array = [
            "nom" => $this->name,
            "slug" => $this->slug,
            "link" => $this->url,
            "meta" => $this->meta,
            "tags" => $this->tag
        ];
        return $array;

    }

    static public function slugify($text)
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public function setImage($siteURL){

        $googlePagespeedData = file_get_contents("https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url=$siteURL&screenshot=true");
        $googlePagespeedData = json_decode($googlePagespeedData, true);
        $screenshot = $googlePagespeedData['screenshot']['data'];
        $screenshot = str_replace(array('_', '-'), array('/', '+'), $screenshot);
        return  "data:image/jpeg;base64," . $screenshot ;
    }
}