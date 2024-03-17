<?php

namespace App\Services;

use App\Exceptions\InvalidOlxURL;
use App\Rules\OLXUrlValidationRule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PHPHtmlParser\Dom;
use PHPHtmlParser\Exceptions\ChildNotFoundException;
use PHPHtmlParser\Exceptions\CircularException;
use PHPHtmlParser\Exceptions\CurlException;
use PHPHtmlParser\Exceptions\NotLoadedException;
use PHPHtmlParser\Exceptions\StrictException;

class PriceParsingService
{
    private Dom $dom;
    public function __construct()
    {
        $this->dom = new Dom();
    }

    /**
     * @throws CurlException
     * @throws ChildNotFoundException
     * @throws CircularException
     * @throws StrictException
     * @throws NotLoadedException
     * @throws InvalidOlxURL
     */
    public function getPrice(string $url) : int {
        $validator = Validator::make(['url' => $url], [
            'url' => ['required', 'url:https', new OLXUrlValidationRule()]
        ]);

        if ($validator->fails())
            throw new InvalidOlxURL("URL Specified is not olx.ua product url");

        $this->dom->loadFromUrl($url, ['removeScripts' => false], new CustomParsingClient());
        $price = Str::replace([' грн.', ' '], '', $this->dom->find(config('olx.parsing-class'))->text);
        return (int) $price;
    }
}
