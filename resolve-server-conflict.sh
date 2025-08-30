#!/bin/bash

echo "🔧 RESOLVING GIT CONFLICT ON SERVER"
echo "=================================="

echo "📋 Current git status:"
git status

echo ""
echo "🔍 Checking for unmerged files:"
git diff --name-only --diff-filter=U

echo ""
echo "⚠️  This will reset to remote state and lose local changes!"
read -p "Continue? (y/N): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]
then
    echo "🚀 Resetting to remote state..."
    git fetch origin
    git reset --hard origin/main
    echo "✅ Reset complete!"
else
    echo "❌ Operation cancelled"
    echo ""
    echo "💡 To manually resolve conflicts:"
    echo "1. Edit conflicted files and remove conflict markers"
    echo "2. Run: git add ."
    echo "3. Run: git commit -m 'Resolve merge conflict'"
fi

echo ""
echo "📊 Final git status:"
git status
