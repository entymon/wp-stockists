## Setup DEV environment

- Start docker `$ docker-compose up`.
- Wordpress should be on `http://localhost:8080`, setup basic configuration.
- log in as admin and open `plugins`, find `jolly-stockists` and enable.
- use composer to install PSR4 autoloader

Remember to change permalinks:
- go to Admin panel and then select `Settings -> Permalinks`
- change permalink to `Post-name`

Don't forget run webpack to build project `cd jolly-stockists/View && yarn start`

## Plugin endpoints: 
- /wp-json/jolly/v1/stockist/stockists/{country_id} 
    
    ```
    Returns all stockists belong to country
    ```
- /wp-json/jolly/v1/stockist/countries/{country_id}

    ```
    Returns all countries
    ```
- /wp-json/jolly/v1/stockist/regions/
    ```
    Returns all regions (of world)
    ```

## Run React view

- go to root of project: ./jolly-stockists/view
- run command `yarn` and install dependencies
- run command `yarn start` dev server run on `http://localhost:3000`
- run command `yarn build` to build project and to see changes in wordpress plugin

## Make plugin work

- add short code `[stockists]`into content of any wordpress page.
- if you don't see any result just info about `DOM element does not exist` in dev console then you can try remove `index.html` from `dist` directory and try again 

## ISO Codes:
https://unstats.un.org/unsd/tradekb/knowledgebase/country-code