@echo off
title Surveillance Serveur - Systeme de Vote
color 0A

echo ============================================
echo   SURVEILLANCE SERVEUR - SYSTEME DE VOTE
echo ============================================
echo.

echo ====== CPU & MEMOIRE (Apache + MySQL) ======
tasklist | findstr /I "httpd.exe mysqld.exe"
echo.
timeout /t 3 /nobreak > nul

cls
echo ====== UTILISATION MEMOIRE DETAILLEE ======
wmic process where name="httpd.exe" get WorkingSetSize,ProcessId
wmic process where name="mysqld.exe" get WorkingSetSize,ProcessId
echo.
timeout /t 3 /nobreak > nul

cls
echo ====== CONNEXIONS MYSQL / LOCKS ======
echo (Assure-toi que mysql est dans le PATH)
mysql -u root -p -e "SHOW PROCESSLIST;"
echo.
timeout /t 3 /nobreak > nul

cls
echo ====== INNODB STATUS (LOCKS / DEADLOCKS) ======
mysql -u root -p -e "SHOW ENGINE INNODB STATUS\G"
echo.
timeout /t 3 /nobreak > nul

echo ====== FIN DE LA SURVEILLANCE ======
pause
