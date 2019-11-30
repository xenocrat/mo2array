## What is this?

mo2array is a PHP class for decoding gettext machine object (.mo) files to array.

## Requirements

* PHP 5.4+

## Usage

Decode .mo file contents:

    $mo = file_get_contents("example.mo");
    $array = mo2array::decode($mo);
    print_r($array);

The above example will output:

    Array
    (
        [0] => Array
            (
                [0] => 
                [1] => Language: it_IT
    MIME-Version: 1.0
    Content-Type: text/plain; charset=UTF-8
    Content-Transfer-Encoding: 8bit
    Plural-Forms: nplurals=2; plural=(n != 1);
    Project-Id-Version: 
    PO-Revision-Date: 
    Last-Translator: 
    Language-Team: 
    X-Generator: Poedit 2.2.4
            )
        [1] => Array
            (
                [0] => goodbye
                [1] => arrivederci
            )
        [2] => Array
            (
                [0] => hello
                [1] => ciao
            )
        [3] => Array
            (
                [0] => Array
                    (
                        [0] => message
                        [1] => messages
                    )
                [1] => Array
                    (
                        [0] => messagio
                        [1] => messagi
                    )
            )
    )

## Return values

Returns an array of the original strings and translation strings discovered in the .mo file. Returns `false` if the file contents cannot be decoded.