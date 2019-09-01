### INSTALLATION
1) Download and extract wherever you want
2) Open terminal, 'cd' to root folder and run 'composer install'
3) Edit database connection in 'config/config.php'
4) upload sql from 'sql/companyFinderBackup.sql'

### USAGE
1) Fill 'IČO' or 'Jméno firmy' and press 'hledat'
    1) only one method can be used at once. If both inputs are filled, script will use only 'IČO'
2) In case, that only one match is found, it is printed and saved to DB or updated
    1) If 'IČO' is used for searching it will use data from Database, if they exist and are not older than one month
3) In case, there are multiple matches found (Which can occur only if searching by company name), it will print a sortable table with clickable link on 'IČO' with details
4) If data is downloaded from Ares, there are saved to DB for later use.
