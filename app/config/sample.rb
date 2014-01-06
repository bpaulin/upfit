server "url.com", :db, :app, :web, :primary => true

set :domain, "url.com"
set :user, "whoami"
set :webserver_user, "www-data"
set :application,   "AppName"
set :branch,        "branch"
set :deploy_to,     "/path/to/code"
set :keep_releases, 3
set   :use_sudo,      true
