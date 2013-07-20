# server "", :app, :web, :primary => true
# set :domain, ""
# set :user, ""
# set :webserver_user, "
# set :application,   ""
# set :branch,        ""
# set :deploy_to,     ""
# set :keep_releases, 5

set :stages,        %w(master develop)
set :default_stage, "develop"
set :stage_dir,     "app/config"
require 'capistrano/ext/multistage'

set   :app_path,      "app"
set   :repository,       "https://github.com/bpaulin/upfit.git"
set   :deploy_via,       :capifony_copy_local
set   :use_composer,     true
set   :use_composer_tmp, true
set   :scm,              :git
set   :model_manager,    "doctrine"
set   :use_sudo,      true
set   :shared_files,      ["app/config/parameters.yml"]
set   :writable_dirs,       ["app/cache", "app/logs"]
set   :permission_method,   :acl
set   :use_set_permissions, true

default_run_options[:pty] = true

logger.level = Logger::INFO

set :default_environment, {
  :LANG => 'en_US.UTF-8'
}

