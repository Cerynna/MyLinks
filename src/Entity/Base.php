<?php
/**
 * Created by PhpStorm.
 * User: cerynna
 * Date: 07/03/18
 * Time: 21:32
 */

namespace Entity;

class Base
{

    public $base;
    public $tags;

    public function __construct()
    {
        $this->base = unserialize(file_get_contents("base.json"));
        $this->tags = unserialize(file_get_contents("tags.json"));
    }

    public function getListLinks()
    {
        return $this->base;
    }

    public function getListTags()
    {
        return $this->tags;
    }

    public function addLink($array, $slug)
    {
        if (is_array($array)) {
            if (is_null($this->base)) {
                $newArray[] = $array;
            } else {
                if (array_key_exists($slug, $this->base)) {
                    if(!isset ($this->base[$slug]["meta"]["image"]) or is_null($this->base[$slug]["meta"]["image"])){
                        $this->base[$slug]["meta"]["image"] = $array["meta"]["image"];
                        file_put_contents("base.json", serialize($this->base));
                        $message = "'" . $array["nom"] . "' Update  dans la liste";
                        return false;
                    }

                    $message = "'" . $array["nom"] . "' existe dans la liste";
                    return false;
                }
                $newArray = array_merge($this->base, [$slug => $array]);
            }
            file_put_contents("base.json", serialize($newArray));
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
                    if (!isset($newArray[$tag])) {
                        $newArray[$tag]['name'] = $tag;
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
            file_put_contents("tags.json", serialize($newArray));
        } else {
            return false;
        }
    }

    public function supLink()
    {

    }

}