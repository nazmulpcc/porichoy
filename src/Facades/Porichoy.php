<?php

namespace Porichoy\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Porichoy\Porichoy
 * @method \GuzzleHttp\Client client() Get the underlying GuzzleHttp client
 * @method \GuzzleHttp\Psr7\Response response() Get the last response
 * @method array autofill(string $nid, string|Carbon $dob, bool $english = false) Autofill NID information based on NID number and date of birth
 * @method array verifyNid(string $nid, string|Carbon $dob, string $person_name, bool $match_name = false) Verify NID information based on NID number, date of birth and name
 * @method subscription() Get subscription details for the current API key
 */
class Porichoy extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'porichoy';
    }
}
