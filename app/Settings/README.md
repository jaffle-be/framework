# Types of settings

- module settings are things like:
    do we use the name or the id as a slug for products
    do we allow comments in the blog system?
    module settings will be account specific
    
- user settings are things like:
    how many items do we want to display in a table on each page by default?
    these items will likely be related to the UI in the admin
    
- theme settings:
    theme settings will be settings that relate to the output on the front side of the application.
    theme settings will vary from theme to theme. A theme could easily have zero settings to be a working theme
     
- an account setting is a setting specific to each account, which has an impact on the entire application
   but cannot be grouped into a user, a module or a theme setting.
   
   
- system settings
   these might not even be implemented, but this could be stuff like:
   live control over the "do we cached repositories"
   
   
   **There can only be 2 types of settings
   Module settings and theme settings**
   
   
Therefor we need to create a trait that allows us to add settings functionality for all these models.

# Database structure

settings_keys
  id
  configurable_type //should be filled in when dealing with theme or module settings
  configurable_id   //should be filled in when dealing with theme or module settings
  key
  
settings_key_translations
  id
  key_id
  locale
  name
  explanation
  

settings_options
  id
  settings_id
  value

settings_option_translations
  id
  option_id
  locale
  name
  explanation

settings_values

  id
  key_id
  option_id
  account_id
  account_id
  configurable_type //the configurable section is duplicate information
  configurable_id //you might want to add it to easily fetch appropriate settings
  configured_type
  configured_id
  
  
or

settings_system_values
setting_id
option_id
account_id


settings_module_values
setting_id
option_id
account_id

settings_theme_values
setting_id
option_id
account_id


# Fetching strategies

For varies simplicity reasons we will always fetch all settings.
It's easier to simply fetch them and use caching then to only load those that we'll actually need.
This would bring to much hassle in structuring when to load what. Without bringing in performance issues.

Example: it would be to easy for a dev to trigger multiple setting queries. Since our settings work using 5 tables,
that's 5 extra queries for each extra trigger.
Caching these would mean that we'll only trigger them once.

**You shouldn't be fetching settings using relations yourself. Always use the repository**