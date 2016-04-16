require 'json'
require 'yaml'

VAGRANTFILE_API_VERSION ||= "2"
confDir = $confDir ||= File.expand_path("vendor/laravel/homestead", File.dirname(__FILE__))

homesteadYamlPath = "Homestead.yaml"
homesteadJsonPath = "Homestead.json"
afterScriptPath = "after.sh"
aliasesPath = "aliases"

require File.expand_path(confDir + '/scripts/homestead.rb')

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
    if File.exists? aliasesPath then
        config.vm.provision "file", source: aliasesPath, destination: "~/.bash_aliases"
    end

    if File.exists? homesteadYamlPath then
        hsconf = YAML::load(File.read(homesteadYamlPath))
        # add bindfs config
        #puts "bindfs target folder: #{hsconf["folders"][0]["to"]}"
        config.nfs.map_uid = Process.uid
        config.nfs.map_gid = Process.gid
        config.bindfs.bind_folder "/var/nfs", hsconf["folders"][0]["to"]

        Homestead.configure(config, hsconf)
    elsif File.exists? homesteadJsonPath then
        Homestead.configure(config, JSON.parse(File.read(homesteadJsonPath)))
    end

    if File.exists? afterScriptPath then
        config.vm.provision "shell", path: afterScriptPath
    end
end
