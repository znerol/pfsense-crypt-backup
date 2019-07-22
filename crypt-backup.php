#!/usr/local/bin/php -f
<?php
/**
 * crypt-backup.php
 *
 * Write encrypted backup file and metadata as JSON to stdout.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

require_once("config.inc");
require_once("util.inc");

function _crypt_backup($passphrase) {
    global $config;

    // Encrypt config.xml
    $tagged = "";
    $raw = file_get_contents("/cf/conf/config.xml");
    $sha256 = hash('sha256', $raw);
    $crypted = encrypt_data($raw, $passphrase);
    tagfile_reformat($crypted, $tagged, "config.xml");

    $result = $config['revision'];
    
    $result['content'] = $tagged;
    $result['sha256'] = $sha256;

    return $result;
}

// Usage.
if ($argc !== 2 || empty($argv[1])) {
    echo "Usage: php " . $argv[0] . " passphrase\n";
    exit(1);
}

print(json_encode(_crypt_backup($argv[1])));
