<?php
echo "<h1>🎨 APBDes Card Layout Test - Centered Design</h1>";

echo "<h2>✅ Layout Improvement:</h2>";
echo "<div style='background:#d1ecf1; padding:15px; border:1px solid #bee5eb; border-radius:5px; margin:15px 0;'>";
echo "<strong>PROBLEM:</strong> Cards stick to left side when only 1-2 cards present<br>";
echo "<strong>SOLUTION:</strong> Center cards for better visual balance";
echo "</div>";

echo "<h2>🔄 Layout Changes:</h2>";
echo "<table border='1' style='border-collapse:collapse; width:100%; margin:15px 0;'>";
echo "<tr style='background:#f8f9fa;'>";
echo "<th style='padding:10px;'>Aspect</th>";
echo "<th style='padding:10px;'>Before (Grid)</th>";
echo "<th style='padding:10px;'>After (Flex)</th>";
echo "<th style='padding:10px;'>Result</th>";
echo "</tr>";

echo "<tr>";
echo "<td style='padding:10px;'><strong>Layout</strong></td>";
echo "<td style='padding:10px;'><code>grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3</code></td>";
echo "<td style='padding:10px;'><code>flex flex-wrap justify-center</code></td>";
echo "<td style='padding:10px;'>✅ Always centered</td>";
echo "</tr>";

echo "<tr>";
echo "<td style='padding:10px;'><strong>Card Width</strong></td>";
echo "<td style='padding:10px;'>Auto (fills grid columns)</td>";
echo "<td style='padding:10px;'><code>w-full md:w-96 lg:w-80</code></td>";
echo "<td style='padding:10px;'>✅ Consistent size</td>";
echo "</tr>";

echo "<tr>";
echo "<td style='padding:10px;'><strong>1 Card</strong></td>";
echo "<td style='padding:10px;'>❌ Left-aligned, looks weird</td>";
echo "<td style='padding:10px;'>✅ Centered, looks balanced</td>";
echo "<td style='padding:10px;'>✅ Much better</td>";
echo "</tr>";

echo "<tr>";
echo "<td style='padding:10px;'><strong>2-3 Cards</strong></td>";
echo "<td style='padding:10px;'>⚠️ Left-aligned</td>";
echo "<td style='padding:10px;'>✅ Centered group</td>";
echo "<td style='padding:10px;'>✅ Professional look</td>";
echo "</tr>";

echo "<tr>";
echo "<td style='padding:10px;'><strong>Many Cards</strong></td>";
echo "<td style='padding:10px;'>✅ Fills grid nicely</td>";
echo "<td style='padding:10px;'>✅ Wraps centered</td>";
echo "<td style='padding:10px;'>✅ Works for all counts</td>";
echo "</tr>";
echo "</table>";

echo "<h2>📱 Responsive Design:</h2>";
echo "<ul>";
echo "<li><strong>Mobile (w-full):</strong> Full width cards, stacked vertically ✅</li>";
echo "<li><strong>Tablet (md:w-96):</strong> Fixed 384px width, centered ✅</li>";
echo "<li><strong>Desktop (lg:w-80):</strong> Fixed 320px width, optimal spacing ✅</li>";
echo "</ul>";

echo "<h2>🎯 Visual Results:</h2>";
echo "<div style='display:flex; gap:20px; margin:20px 0;'>";

echo "<div style='flex:1; border:1px solid #dc3545; padding:15px; border-radius:5px;'>";
echo "<h3 style='color:#dc3545; margin-top:0;'>❌ Before (Grid - Left Aligned)</h3>";
echo "<div style='display:flex; gap:10px;'>";
echo "<div style='width:120px; height:80px; background:#e9ecef; border-radius:5px; display:flex; align-items:center; justify-content:center; font-size:12px;'>Card 1</div>";
echo "<div style='flex:1;'></div>";
echo "</div>";
echo "<p style='font-size:14px; color:#666; margin:10px 0 0 0;'>Single card looks lonely on the left</p>";
echo "</div>";

echo "<div style='flex:1; border:1px solid #28a745; padding:15px; border-radius:5px;'>";
echo "<h3 style='color:#28a745; margin-top:0;'>✅ After (Flex - Centered)</h3>";
echo "<div style='display:flex; justify-content:center; gap:10px;'>";
echo "<div style='width:120px; height:80px; background:#d1ecf1; border-radius:5px; display:flex; align-items:center; justify-content:center; font-size:12px;'>Card 1</div>";
echo "</div>";
echo "<p style='font-size:14px; color:#666; margin:10px 0 0 0;'>Single card perfectly centered</p>";
echo "</div>";

echo "</div>";

echo "<h2>🚀 Test APBDes Page:</h2>";
echo "<div style='text-align:center; margin:30px 0;'>";
echo "<a href='/transparansi-anggaran' target='_blank' style='background:#007bff; color:white; padding:15px 30px; text-decoration:none; border-radius:5px; font-size:18px; display:inline-block;'>";
echo "🎨 View Centered APBDes Layout";
echo "</a>";
echo "</div>";

echo "<h2>💡 Benefits:</h2>";
echo "<ol>";
echo "<li><strong>Professional Look:</strong> Cards always well-positioned</li>";
echo "<li><strong>Scalable:</strong> Works with 1 card or many cards</li>";
echo "<li><strong>Responsive:</strong> Adapts to all screen sizes</li>";
echo "<li><strong>User-Friendly:</strong> Easy to scan and read</li>";
echo "<li><strong>Production-Ready:</strong> Handles dynamic content gracefully</li>";
echo "</ol>";

echo "<hr>";
echo "<p><small>🕐 Layout test at: " . date('Y-m-d H:i:s') . "</small></p>";
?>
