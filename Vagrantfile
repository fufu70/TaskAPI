Vagrant.configure(2) do |config|

  config.vm.box = "v0rtex/xenial64"
  
  # Mentioning the SSH Username/Password:
  config.vm.boot_timeout = 100000000000
  config.vm.synced_folder "src/", "/var/www/task_api", owner: "www-data", group: "www-data"
  config.vm.synced_folder "vagrant/", "/home/vagrant/install", owner: "vagrant", group: "vagrant"
  config.vm.synced_folder "sql/", "/home/vagrant/sql", owner: "vagrant", group: "vagrant"

  # Begin Configuring
  config.vm.define "task_api" do|task_api|
    task_api.vm.hostname = "task_api.net" # Setting up hostname
    task_api.vm.network "private_network", ip: "192.168.201.75" # Setting up machine's IP Address
    task_api.vm.provision :shell, path: "vagrant/install.sh" # Provisioning with script.sh
  end

  config.vm.provider :virtualbox do |vb|
    vb.gui = true
  end

  # End Configuring
end