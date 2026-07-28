# php
- Place jQuery/DataTables initialization scripts in layout/footer.php, not inline in page files before the footer include, to ensure all JS dependencies are loaded first. Confidence: 0.70
- Keep implementations simple and match the reference/spec exactly — don't over-engineer or add extra features beyond what's shown in the reference. Confidence: 0.65
- Separate static configuration/setup code (e.g., SMTP config, object instantiation) from conditional execution blocks — place config outside the if/else, keep only dynamic data and the action call inside the condition. Confidence: 0.75
