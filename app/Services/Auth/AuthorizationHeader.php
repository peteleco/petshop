<?php

namespace App\Services\Auth;

use Illuminate\Http\Request;

class AuthorizationHeader
{
    /**
     * Authorization type
     * @var string
     */
    protected string  $type = 'Bearer';

    protected string $headerName = 'Authorization';

    public function token(Request $request): ?string
    {
        $header = $request->headers->get($this->headerName);
        // Invalid header
        if(!$header) {
            return null;
        }
        // Invalid type
        if(!str_contains($header, $this->type)) {
            return null;
        }

        return (string)str_replace([$this->type, ' '], '',$header);
    }

}