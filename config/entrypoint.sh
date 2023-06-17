#!/bin/bash

# Iniciar o serviço SSH
service ssh restart

# Iniciar o servidor web
nginx -g 'daemon off;'