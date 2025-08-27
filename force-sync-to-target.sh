#!/bin/bash

echo "=== Force Sync cPanel to Specific Commit ==="

# Target commit: Add cPanel production database user cleanup scripts
TARGET_COMMIT="3171a09"

echo "Target commit: $TARGET_COMMIT"
echo "Current situation diagnosis..."

# Show current status
echo -e "\n1. Current local status:"
git status

# Show current commit
echo -e "\n2. Current local commit:"
git log --oneline -1

# Show remote status
echo -e "\n3. Fetching from remote:"
git fetch --all

# Show what's on remote
echo -e "\n4. Remote main commit:"
git log origin/main --oneline -1

# Show divergence
echo -e "\n5. Checking divergence:"
git log --oneline --graph HEAD origin/main -10

echo -e "\n=== SOLUTION: Force sync to target commit ==="

# Method 1: Reset local to target commit
echo -e "\n6. Resetting local to target commit $TARGET_COMMIT:"
git reset --hard $TARGET_COMMIT

# Method 2: Force push to update remote
echo -e "\n7. Force pushing to update remote:"
git push origin main --force

echo -e "\n8. Final verification:"
git log --oneline -3

echo -e "\n=== INSTRUCTIONS FOR CPANEL ==="
echo "Now run this in cPanel terminal:"
echo "git fetch --all"
echo "git reset --hard origin/main" 
echo "git clean -fd"
echo ""
echo "This will force cPanel to match the target commit: $TARGET_COMMIT"

echo -e "\n=== Alternative if above doesn't work ==="
echo "If cPanel still shows divergent branches, run:"
echo "git reset --hard $TARGET_COMMIT"
echo "This will directly set cPanel to the target commit"
