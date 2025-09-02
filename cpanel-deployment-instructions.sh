#!/bin/bash

# CPANEL PRODUCTION DEPLOYMENT SCRIPT
# Script untuk mengatasi error role integer → string conversion

echo "========================================="
echo "  CPANEL USER ROLE DEPLOYMENT SCRIPT    "
echo "========================================="
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${BLUE}📋 ISSUE DETECTED:${NC}"
echo "   Role column is INTEGER type, but we need VARCHAR for string roles"
echo "   Error: 'Incorrect integer value: SuperAdmin for column role'"
echo ""

echo -e "${YELLOW}🛠️  SOLUTION STEPS:${NC}"
echo ""

echo -e "${GREEN}Step 1: Fix Database Structure${NC}"
echo "   Run this command first to change column type:"
echo -e "${BLUE}   php fix_database_structure.php${NC}"
echo ""

echo -e "${GREEN}Step 2: Update User Roles${NC}" 
echo "   After structure is fixed, run:"
echo -e "${BLUE}   php update_user_roles_production.php${NC}"
echo ""

echo -e "${GREEN}Step 3: Verify Results${NC}"
echo "   Check your admin panel:"
echo -e "${BLUE}   Visit: http://yourdomain.com/admin/manage-akun${NC}"
echo ""

echo -e "${YELLOW}⚠️  IMPORTANT NOTES:${NC}"
echo "• Always backup database before making changes"
echo "• Test on staging environment first if possible"  
echo "• Delete script files after successful deployment"
echo ""

echo -e "${RED}🚨 MANUAL ALTERNATIVE:${NC}"
echo "If scripts fail, execute this SQL manually in cPanel MySQL:"
echo ""
echo -e "${BLUE}-- Step 1: Change column type${NC}"
echo "ALTER TABLE users MODIFY COLUMN role VARCHAR(50) DEFAULT 'Admin';"
echo ""
echo -e "${BLUE}-- Step 2: Update role values${NC}" 
echo "UPDATE users SET role = 'SuperAdmin' WHERE role = '0' OR role = 0;"
echo "UPDATE users SET role = 'Admin' WHERE role = '1' OR role = 1;"
echo "UPDATE users SET role = 'Writer' WHERE role = '2' OR role = 2;"
echo "UPDATE users SET role = 'Editor' WHERE role = '3' OR role = 3;"
echo ""

echo -e "${GREEN}✅ EXPECTED FINAL RESULT:${NC}"
echo "• Database column: users.role VARCHAR(50)"
echo "• Role values: 'SuperAdmin', 'Admin', 'Writer', 'Editor'"
echo "• Admin panel: Role dropdown with string options"
echo "• All user logins: Working normally"
echo ""

echo "========================================="
echo -e "${GREEN}Ready to proceed? Run the commands above!${NC}"
echo "========================================="
