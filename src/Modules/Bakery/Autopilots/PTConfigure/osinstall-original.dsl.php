#Logging log
#  log-message "Lets Bake an ISO"
#
#Download file
#  label 'Download the ISO file'
#  source "$$iso_file_remote_location"
#  target "/opt/ptvirtualize/boxes/$$var_os.$$var_os_version.$$var_os_group.iso"
#  yes
#  guess
#
Bakery osinstall
  label "The OS Installation Stage"
  iso "/home/pharaoh/Downloads/ubuntu-16.04.6-server-amd64.iso"
  name "$$vm_name"
  ostype "Ubuntu_64"
  memory "512"
  vram "33"
  cpus "1"
  ssh_forwarding_port "9988"
  user_name ptv
  user_pass ptv
  full_user "Pharaoh Virtualize"
  locale en_GB
  country GB
  language EN
  gui_mode gui
  notify-delay 60
  guess

Mkdir path
  label "Ensure Temp Directory for Virtufile"
  path "/tmp/ptv_vm_osinstall"
  recursive true
  guess

RunCommand execute
  label "Initialize a matching name"
  command 'cd /tmp/ptv_vm_osinstall && ptvirtualize init now --name="{{{ var::vm_name }}}" --vars="/opt/ptconfigure/ptconfigure/src/Modules/Bakery/Autopilots/PTConfigure/vars.php" -yg'
  guess

RunCommand execute
  label "PTV Halt it"
  command 'cd /tmp/ptv_vm_osinstall && ptvirtualize halt now --die-hard -yg'
  guess
  ignore_errors

RunCommand execute
  label "PTV Package the Virtual Machine into a Box file"
  command 'cd /tmp/ptv_vm_osinstall && ptvirtualize box package --name="$$full_name" --vmname="$$vm_name" --group="ptvirtualize" --description="$$vm_description" --target="/opt/ptvirtualize/boxes" -yg '
  guess

RunCommand execute
  label "Destroy the Virtual Machine"
  command "cd /tmp/ptv_vm_osinstall && ptvirtualize destroy now"
  guess

RunCommand execute
  label "Starting PT Repositories Upload"
  command "curl -F group=development -F version=${var_os_version} -F file=@/path/to/file -F control=BinaryServer -F action=serve -F item=${var_os} -F auth_user=${var_auth_user} -F auth_pw=${var_auth_pw} https://repositories.internal.pharaohtools.com/index.php"
  guess

Logging log
  log-message "Baking of Image Completed Packaging "
