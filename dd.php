<?php

function dd(...$vars)
{
    echo '<style>
            :root {
                --primary-color: #61dafb;
                --secondary-color: #98c379;
                --background-color: #202124;
                --box-color: #292a2d;
                --text-color: #e8eaed;
                --header-hover: #4e535b;
                --border-color: #3c4043;
                --error-color: #e06c75;
            }
            body { font-family: "Fira Code", "Consolas", monospace; background-color: var(--background-color); color: var(--text-color); margin: 0; padding: 20px; }
            .dd-container { margin: 20px auto; max-width: 90%; font-size: 14px; line-height: 1.6; }
            .dd-box { background: var(--box-color); border-radius: 10px; overflow: hidden; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4); margin-bottom: 20px; border: 1px solid var(--border-color); }
            .dd-header { cursor: pointer; background: var(--border-color); padding: 15px; font-size: 16px; font-weight: bold; display: flex; justify-content: space-between; align-items: center; color: var(--primary-color); transition: background 0.3s; }
            .dd-header:hover { background: var(--header-hover); }
            .dd-header .index { font-size: 12px; color: var(--secondary-color); }
            .dd-header .actions { display: flex; gap: 10px; }
            .dd-header .action-btn { font-size: 12px; padding: 5px 10px; color: var(--text-color); background: var(--box-color); border: 1px solid var(--border-color); border-radius: 5px; cursor: pointer; }
            .dd-header .action-btn:hover { background: var(--header-hover); color: var(--primary-color); }
            .dd-content { display: none; background: var(--box-color); padding: 15px; color: var(--text-color); border-top: 1px solid var(--border-color); }
            .dd-content pre { margin: 0; color: var(--secondary-color); font-family: "Fira Code", monospace; white-space: pre-wrap; word-wrap: break-word; overflow-x: auto; }
            .dd-toggle { transition: transform 0.3s; }
            .dd-toggle.open { transform: rotate(90deg); }
            .dd-footer { background: var(--border-color); text-align: center; padding: 10px; font-size: 12px; color: var(--text-color); border-top: 1px solid var(--header-hover); }
          </style>';

    echo '<script>
            document.addEventListener("DOMContentLoaded", function () {
                document.querySelectorAll(".dd-header").forEach(function (header) {
                    header.addEventListener("click", function () {
                        const content = header.nextElementSibling;
                        const toggle = header.querySelector(".dd-toggle");
                        if (content.style.display === "none" || !content.style.display) {
                            content.style.display = "block";
                            toggle.classList.add("open");
                        } else {
                            content.style.display = "none";
                            toggle.classList.remove("open");
                        }
                    });
                });

                document.querySelectorAll(".action-save-json").forEach(function (action) {
                    action.addEventListener("click", function () {
                        const content = action.closest(".dd-box").querySelector(".dd-content pre").innerText;
                        const blob = new Blob([content], { type: "application/json" });
                        const url = URL.createObjectURL(blob);
                        const link = document.createElement("a");
                        link.href = url;
                        link.download = "debug-output.json";
                        link.click();
                        URL.revokeObjectURL(url);
                    });
                });

                document.querySelectorAll(".action-copy").forEach(function (action) {
                    action.addEventListener("click", function () {
                        const content = action.closest(".dd-box").querySelector(".dd-content pre").innerText;
                        navigator.clipboard.writeText(content).then(function () {
                            alert("Copied to clipboard!");
                        }).catch(function () {
                            alert("Failed to copy.");
                        });
                    });
                });
            });
          </script>';

    echo '<div class="dd-container">';
    foreach ($vars as $index => $var) {
        echo '<div class="dd-box">';
        echo '<div class="dd-header">';
        echo 'Debug Output <span class="index">#' . ($index + 1) . '</span>';
        echo '<div class="actions">';
        echo '<button class="action-btn action-save-json">Save as JSON</button>';
        echo '<button class="action-btn action-copy">Copy</button>';
        echo '</div>';
        echo '<span class="dd-toggle">▶</span>';
        echo '</div>';
        echo '<div class="dd-content">';
        echo '<pre>' . htmlspecialchars(json_encode($var, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), ENT_QUOTES, 'UTF-8') . '</pre>';
        echo '</div>';
        echo '<div class="dd-footer">Debugging with ❤️ and Precision</div>';
        echo '</div>';
    }
    echo '</div>';
    die(1);
}

dd(['Aghabidareh' => 11]);
