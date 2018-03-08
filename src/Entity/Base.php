<?php
/**
 * Created by PhpStorm.
 * User: cerynna
 * Date: 07/03/18
 * Time: 21:32
 */

namespace Entity;

/*
 * a:0:{}
 *
 */
class Base
{

    public $base;
    public $tags;
    public $badWords;

    public function __construct()
    {
        $this->base = unserialize(file_get_contents("base.json"));
        $this->tags = unserialize(file_get_contents("tags.json"));
        $this->badWords = unserialize(file_get_contents("badWords.json"));
    }

    public function getListLinks()
    {
        return $this->base;
    }

    public function getListTags()
    {
        usort($this->tags, function ($a, $b) {
            return $a['nb'] <=> $b['nb'];
        });
        $listTags = array_reverse($this->tags);
        return $listTags;
    }

    public function addLink($array, $slug)
    {
        if (is_array($array)) {
            if (is_null($this->base)) {
                $newArray[] = $array;
            } else {
                if (array_key_exists($slug, $this->base)) {
                    if (!isset ($this->base[$slug]["meta"]["image"]) or is_null($this->base[$slug]["meta"]["image"])) {
                        $this->base[$slug]["meta"]["image"] = $array["meta"]["image"];

                        $this->saveJson("base.json", $this->base);
                        $message = "'" . $array["nom"] . "' Update  dans la liste";
                        return false;
                    }

                    $message = "'" . $array["nom"] . "' existe dans la liste";
                    return false;
                }
                $newArray = array_merge($this->base, [$slug => $array]);
            }
            $this->saveJson("base.json", $newArray);
            return true;
        } else {
            return false;
        }
    }

    public function addTags($tags, $slug)
    {
        if (is_array($tags)) {
            if (is_null($this->tags)) {
                $newArray[] = $tags;
            } else {
                $newArray = $this->tags;
                foreach ($tags as $tag) {
                    $tag = preg_replace('/[^a-z]+/i', '', $tag);
                    if (strlen($tag) >= 2) {
                        if (!isset($newArray[$tag]) and !in_array($tag, $this->badWords)) {
                            $newArray[$tag]['name'] = strtolower($tag);
                            $newArray[$tag]['nb'] = 1;
                            $newArray[$tag]['links'][] = $slug;

                        } else {
                            if (!in_array($slug, $newArray[$tag]['links'])) {
                                $newArray[$tag]['nb'] = $newArray[$tag]['nb'] + 1;
                                $newArray[$tag]['links'][] = $slug;
                                $newArray[$tag]['links'] = array_unique($newArray[$tag]['links']);
                            }

                        }
                    }
                }
            }
            $this->saveJson("tags.json", $newArray);
        } else {
            return false;
        }
    }

    public function addBadWord($name, $links)
    {
        $links = explode(',', $links);
        foreach ($links as $link) {
            if (($key = array_search($name, $this->base[$link]["tags"])) !== false) {
                unset($this->base[$link]["tags"][$key]);
                $this->saveJson("base.json", $this->base);
            }
        }

        unset($this->tags[$name]);
        $this->saveJson("tags.json", $this->tags);


        if (is_null($this->badWords)) {
            $newArray[] = $name;
        } else {
            array_push($this->badWords, $name);
        }

        $this->saveJson("badWords.json", array_unique($this->badWords));


    }

    public function addTagToLink($slug, $tag)
    {

        $this->base[$slug]["tags"][] = $tag;
        $this->saveJson("base.json", $this->base);
        $this->addTags([$tag], $slug);

    }

    public function supLink()
    {

    }

    public function saveJson($filename, $array)
    {
        file_put_contents($filename, serialize($array));
    }

}