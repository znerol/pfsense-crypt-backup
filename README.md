# pfsense-crypt-backup

Write encrypted backup file and metadata as JSON to stdout.

## Installation

1. Copy `crypt-backup.php` to `/usr/local/bin/crypt-backup.php`.
2. `chmod +x /usr/local/bin/crypt-backup.php

## Usage

Local:

```
/usr/local/bin/crypt-backup.php "my super secret passphrase" > pfsense-config.json
```

Remote:

```
ssh root@pfsense /usr/local/bin/crypt-backup.php "my super secret passphrase" > pfsense-config.json
```

## Tips

* Use `jq` to extract encrypted `config.xml` from JSON:
  ```
  jq -r ".content" pfsense-config.json > config.xml
  ```
* Use `jq` to extract backup metadata from JSON:
  ```
  jq "del(.content)" pfsense-config.json > meta.json
  ```
* Add restricted SSH key to pfsense admin account which is only capable of pulling an encrypted backup.
  ```
  no-agent-forwarding,no-port-forwarding,no-pty,no-X11-forwarding,command="/usr/local/bin/crypt-backup.php 'super secret passphrase'" ssh-rsa AAAAB3[...]
  ```
