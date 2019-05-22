#!/usr/bin/env bash
GREEN='\033[1;30m'
NC='\033[0m'
WHITE='\033[1;37m'

echo -e "\n"
echo -e "${GREEN}######################################"
echo -e "#######    ${NC}COMPOSER INSTALL    ${GREEN}#######"
echo -e "######################################\n${NC}"
composer install

echo -e "\n"
echo -e "${GREEN}######################################"
echo -e "#######    ${NC}COMPOSER UPDATE     ${GREEN}#######"
echo -e "######################################\n${NC}"
composer update

echo -e "\n"
echo -e "${GREEN}######################################"
echo -e "#######    ${NC}.ENV CREATION       ${GREEN}#######"
echo -e "######################################\n${NC}"
cp ./.env.dist ./.env

echo -e "\n"
echo -e "${GREEN}######################################"
echo -e "#######    ${NC}APP SETUP           ${GREEN}#######"
echo -e "######################################\n${NC}"
php console/yii app/setup --interactive=0

echo -e "\n"
echo -e "${GREEN}######################################"
echo -e "#######    ${NC}NPM INSTALL         ${GREEN}#######"
echo -e "######################################\n${NC}"
npm install

echo -e "\n"
echo -e "${GREEN}######################################"
echo -e "#######    ${NC}NPM RUN BUILD       ${GREEN}#######"
echo -e "######################################\n${NC}"
npm run build
