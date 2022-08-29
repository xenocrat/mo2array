## What is this?

mo2array is a PHP class for decoding GNU gettext machine object (.mo) files to array.

## Requirements

* PHP 8.0+

## Usage

Decode .mo file contents:

    $mo = file_get_contents("example.mo");
    $throw_exceptions = false;
    $array = \xenocrat\mo2array::decode($mo, $throw_exceptions);
    print_r($array);

The above example will output:

    Array
    (
        [0] => Array
            (
                [0] => Array
                    (
                        [0] => 
                    )
                [1] => Array
                    (
                        [0] => Language: it_IT
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
            )
        [1] => Array
            (
                [0] => Array
                    (
                        [0] => goodbye
                    )
                [1] => Array
                    (
                        [0] => arrivederci
                    )
            )
        [2] => Array
            (
                [0] => Array
                    (
                        [0] => hello
                    )
                [1] => Array
                    (
                        [0] => ciao
                    )
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

Returns an array of the original strings and translation strings discovered in the .mo file, or `false` if the file contents cannot be decoded. Optionally the class will throw exceptions in case of decoding failure.

Strings discovered in the .mo file are returned as encoded.
