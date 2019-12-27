Golden Contact Computing - PTConfigure Tool
-------------------

About:
-----------------
This tool helps with setting up boxes. Its intended to get any box in your standard main environments to be
up and running quickly. It's not meant to be an exhaustive list of installs for everything you'll ever need to
install (obviously)

Can be used to set up a Development Client, Development Server, Testing Server, or Production Server in minutes

... Staging/UAT is not missing from the list because in "Software my box has installed" terms it should be the
same as Production.

Furthermore, especially for Production, this is intended to be a quick solution to get you up and running and I
do not and would never recommend going into Production without checking things for yourself. In essence, I can
give you lots of tasty alcohol to help encourage your flow, but I can't hold it for you when you need to go.

So, there are basically only a few simple commands...

ptconfigure install cherry-pick - Pick individual or multiple bits of software to install
ptconfigure install autopilot *Your Custom File* - Use preset defaults to perform an unattended installation

ptconfigure install autopilot dev-client - Install a preconfigured set of software for a dev client (Your Workstation)
ptconfigure install autopilot dev-server - Install a preconfigured set of software for a dev server (Team Playaround Box)
ptconfigure install autopilot test-server - Install a preconfigured set of software for a Build/Testing server
ptconfigure install autopilot git-server - Install a preconfigured set of software for a Git SCM server
ptconfigure install autopilot production - Install a preconfigured set of software for a Production server (Public Server)

add silent or autogen like ...

ptconfigure install autopilot dev-client-silent
ptconfigure install autopilot dev-server-autogen

... which pretty much do as described ... all have the option of providing silent or autogen as a parameter.

The silent parameter will mean no questions at all will be asked, and defaults provided by ptconfigure will be
used. It is, of course down to you to change them. At the end of the install, the users, passwords, install
folders and other install data will be provided to you as screen output.

The autogen parameter will mean no questions at all will be asked, and defaults provided by ptconfigure will be
used for non-sensitive data, like install folders. Sensitive data such as passwords will be autogenerated
as needed. It is, of course down to you to change them if you want to. It is also down to you to save the
output. At the end of the install, the users, passwords, install folders and other install data will be
provided to you as screen output.



Installation
-----------------

To install ptconfigure cli on your machine do the following. If you already have php5 and git installed skip line 1:

apt-get php5 git

git clone https://github.com/phpengine/ptconfigure && sudo php ptconfigure/install-silent

or...

git clone https://github.com/phpengine/ptconfigure && sudo php ptconfigure/install
(If you want to choose the install directory)

... that's it, now the ptconfigure command should be available at the command line for you.

-------------------------------------------------------------

Available Commands:
---------------------------------------

install

    - dev-client
    install a dev client machine for you to work on, a bunch of IDE's, DB's and a complete set of the
    tools you need to start work immediately. You can use the keyword silent which will use ptconfigure's
    default values to perform an unattended install. You can also use the keyword autogen which will
    generate values for sensitive data to perform an unattended install.
    example: ptconfigure install autopilot dev-client
    example: ptconfigure install autopilot dev-client-silent
    example: ptconfigure install autopilot dev-client-autogen

    - dev-server
    Install the preconfigured list of software for a developers server. Specifying a user to install software
    as is required. You can use the keyword silent which will use ptconfigure's default values to perform an
    unattended install. You can also use the keyword autogen which will generate values for sensitive data
    to perform an unattended install.
    example: ptconfigure install autopilot dev-server
    example: ptconfigure install autopilot dev-server-silent
    example: ptconfigure install autopilot dev-server-autogen

    - test-server
    Install the preconfigured list of software for a testing server. Specifying a user to install software
    as is required. You can use the keyword silent which will use ptconfigure's default values to perform an
    unattended install. You can also use the keyword autogen which will generate values for sensitive data
    to perform an unattended install.
    example: ptconfigure install autopilot test-server
    example: ptconfigure install autopilot test-server-silent
    example: ptconfigure install autopilot test-server-autogen

    - autopilot
    Perform an installation, or multiple installations of software, using the configurations and options
    provided in an autopilot file.
    example: ptconfigure install autopilot *autopilot-file*

    - cherry-pick @todo
    Install indivdual available programs
    example: ptconfigure install cherry-pick

    @todo quite a few on this one, currently git & tools, phpunit, phpcs, phpmd, ruby, jenkin
    selenium, devhelper are available. Installers for mysql, apache2, php modules, apache modules,
    git web/viewgit, web page analyzer, intelli j, java (for intellij), eclipse,
    geany, mysql workbench, hip-hop, devhelper, all
    still to come