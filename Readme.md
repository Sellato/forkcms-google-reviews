# ForkCMS Google Review Module

Display your Google Review score in your website.

### Installation

- Download this module
- Upload to your website
- Go to [Google Cloud Console](https://console.cloud.google.com/) and create an API key
- Add the [Places api](https://console.cloud.google.com/marketplace/product/google/places-backend.googleapis.com) to the created key
- Enter the API in the module settings
- Go to the [Place ID Finder](https://developers.google.com/maps/documentation/javascript/examples/places-placeid-finder) to find the correct Place ID for your location
- Create a cronjob which runs the update score command: `php bin/console google-review:update-score`

The module doesn't require any database actions at the moment. All the values are saved in the `module_settings` table.

When you are running this command in a product environment you should call `php bin/console google-review:update-score --env=prod`, otherwise the settings aren't updated.