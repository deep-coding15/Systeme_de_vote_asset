@echo off
title Surveillance Serveur - Apache / MySQL / CPU / RAM
color 0A

echo ============================================
echo   MONITORING SERVEUR - SYSTEME DE VOTE
echo ============================================
echo.
echo Appuyez sur CTRL+C pour arreter
echo.

:LOOP
cls
echo ====== %DATE% %TIME% ======
echo.

echo ---- UTILISATION CPU & RAM ----
wmic cpu get loadpercentage
echo.
wmic OS get FreePhysicalMemory,TotalVisibleMemorySize /Value
echo.

echo ---- PROCESSUS APACHE (httpd) ----
tasklist | findstr /I httpd.exe
echo.

echo ---- PROCESSUS MYSQL (mysqld) ----
tasklist | findstr /I mysqld.exe
echo.

timeout /t 5 >nul

goto LOOP
