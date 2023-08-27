<?php
    namespace xenocrat;

    class mo2array {
        const MO2ARRAY_VERSION_MAJOR = 3;
        const MO2ARRAY_VERSION_MINOR = 2;

        const MO_MAGIC_WORD_BE       = "950412de";
        const MO_MAGIC_WORD_LE       = "de120495";
        const MO_SIZEOF_HEADER       = 28;

        public static function decode($mo, $throw = false): array|false {
            if (!is_string($mo))
                throw new \Exception("File must be supplied as a string.");

            $array = array();
            $length = strlen($mo);
            $big_endian = null;

            if (self::MO_SIZEOF_HEADER > $length) {
                if (!$throw)
                    return false;

                throw new \Exception("File does not contain MO data.");
            }

            $id = unpack("H8magic", $mo);

            if ($id["magic"] == self::MO_MAGIC_WORD_BE)
                $big_endian = true;

            if ($id["magic"] == self::MO_MAGIC_WORD_LE)
                $big_endian = false;

            # Neither magic word matches; not a valid .mo file.
            if (!isset($big_endian)) {
                if (!$throw)
                    return false;

                throw new \Exception("File does not contain MO data.");
            }

            $unpack = ($big_endian) ?
                "Nformat/Nnum/Nor/Ntr" :
                "Vformat/Vnum/Vor/Vtr" ;

            $mo_offset = unpack($unpack, $mo, 4);

            $unpack = ($big_endian) ?
                "Nlength/Noffset" :
                "Vlength/Voffset" ;

            for ($i = 0; $i < $mo_offset["num"]; $i++) {
                $or_str_offset = $mo_offset["or"] + ($i * 8);
                $tr_str_offset = $mo_offset["tr"] + ($i * 8);

                if (($or_str_offset + 8) > $length) {
                    if (!$throw)
                        return false;

                    throw new \Exception("File ended unexpectedly.");
                }

                if (($tr_str_offset + 8) > $length) {
                    if (!$throw)
                        return false;

                    throw new \Exception("File ended unexpectedly.");
                }

                $or_str_meta = unpack($unpack, $mo, $or_str_offset);
                $tr_str_meta = unpack($unpack, $mo, $tr_str_offset);

                $or_str_end = $or_str_meta["offset"] + $or_str_meta["length"];
                $tr_str_end = $tr_str_meta["offset"] + $tr_str_meta["length"];

                if ($or_str_end > $length) {
                    if (!$throw)
                        return false;

                    throw new \Exception("File ended unexpectedly.");
                }

                if ($tr_str_end > $length) {
                    if (!$throw)
                        return false;

                    throw new \Exception("File ended unexpectedly.");
                }

                $or_str_data = substr(
                    $mo,
                    $or_str_meta["offset"],
                    $or_str_meta["length"]
                );

                $tr_str_data = substr(
                    $mo,
                    $tr_str_meta["offset"],
                    $tr_str_meta["length"]
                );

                # Discover null-separated plural forms.
                $or_str_data = explode("\0", $or_str_data);
                $tr_str_data = explode("\0", $tr_str_data);

                $array[] = array($or_str_data, $tr_str_data);
            }

            return $array;
        }
    }
