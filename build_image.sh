#!/bin/bash

if [[ $1 == 1 ]]
then
    echo "Building postgresql image ..."
    cd Images_build/postgresql/
    docker build -t vulnerable .
    docker tag vulnerable:latest vulnerable:staging
    exit 0
elif [[ $1 == 2 ]]
then
    echo "Building php image ..."
    cd Images_build/php/
    docker build -t php .
    docker tag php:latest php:staging
# Start no matter vulnerabilities
elif [[ $1 == 3 ]]
then
    echo "Starting docker-compose build"
    docker-compose up -d
# Check for vulnerabilities    
elif [[ $1 == 4 ]]
then
    echo "Starting scan"
    
    scan_result=$(docker scan php:staging --severity high --json | jq -r '.uniqueCount')
    scan_result_postgresql=$(docker scan vulnerable:staging --severity high --json | jq -r '.uniqueCount')
    
    # If any of the images are vulnerable we stop the execution

    if [[ $scan_result -gt 10 ]] || [[ $scan_result_postgresql -gt 10 ]]
    then
        echo "Some of this images are vulnerable."
        exit 1
    else
        docker-compose up -d
    fi

else
    echo "Introduced value is not correct..."
    echo "[1] Building PostgreSQL Image"
    echo "[2] Building PHP Image"
    echo "[3] Run docker-compose without check."
    echo "[4] Run docker-compose and security checks."
fi
 