echo '

function gcBranches() {
    # echo "$1"
    git checkout -b $1
    git submodule foreach --recursive git checkout -b $1
}

function gcSubmodules() {
    # echo "$1"
    git checkout $1
    git submodule foreach --recursive git checkout $1
}

function gpSubmodules() {
    # echo "$1"
    git pull upstream $1
    git submodule foreach --recursive git checkout $1
}

function wakeup() {
    gcSubmodules master
    gpSubmodules master
}' >> ~/.bashrc 