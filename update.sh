#!/usr/bin/env bash
GREEN='\033[1;30m'
NC='\033[0m'
WHITE='\033[1;37m'

echo -e "\n"
echo -e "${GREEN}######################################"
echo -e "#######    ${NC}COMPOSER INSTALL    ${GREEN}#######"
echo -e "######################################\n${NC}"
composer install -vvv

echo -e "\n"
echo -e "${GREEN}######################################"
echo -e "#######    ${NC}COMPOSER UPDATE     ${GREEN}#######"
echo -e "######################################\n${NC}"
composer update -vvv


echo -e "\n"
echo -e "${GREEN}######################################"
echo -e "#######    ${NC}MIGRATE             ${GREEN}#######"
echo -e "######################################\n${NC}"
php console/yii mad-migrate/up --interactive=0
