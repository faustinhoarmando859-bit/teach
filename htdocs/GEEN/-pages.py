from pathlib import Path
import re

root = Path(r'd:\xampp\htdocs\GEEN')
modules = ['students','teachers','classes','subjects','results','attendance','fees']

def wrap_page(s, title, subtitle=''):
    if '<div class="main">' in s:
        return s
    s = s.replace('<body>', '<body>\n<?php include "../includes/sidebar.php"; ?>\n\n<div class="main">\n    <div class="page-content">')
    if '</body>' in s:
        s = s.replace('</body>', '    </div>\n</div>\n</body>', 1)
    return s

for mod in modules:
    base = root / mod
    label = mod[:-1].capitalize()

    p = base / 'index.php'
    s = p.read_text(encoding='utf-8')
    s = s.replace('class="button"', 'class="view-btn"')
    s = s.replace('class="button delete"', 'class="delete-btn"')
    s = s.replace('class="add-button"', 'class="add-btn"')
    s = s.replace('class="button add-button"', 'class="add-btn"')
    s = re.sub(r'<h1>.*?</h1>', '', s, count=1, flags=re.S)
    s = s.replace('<body>', '<body>\n<?php include "../includes/sidebar.php"; ?>\n\n<div class="main">\n    <div class="page-content">', 1)
    s = s.replace('</body>', '        </div>\n    </div>\n</body>', 1)
    s = s.replace('<table class="data-table">', '<table class="data-table">', 1)
    s = re.sub(r'<div class="table-wrapper"><table', '<div class="table-panel"><div class="table-wrapper"><table', s, count=1)
    s = re.sub(r'</table>\s*</div>', '</table></div></div>', s, count=1)
    s = s.replace('<div class="page-content">\n', '<div class="page-content">\n    <div class="page-header">\n        <h1>' + mod.capitalize() + '</h1>\n        <div class="header-actions">\n            <a href="add.php" class="add-btn">+ Add ' + label + '</a>\n            <a href="../dashboard.php" class="back">Back to Dashboard</a>\n        </div>\n    </div>\n', 1)
    p.write_text(s, encoding='utf-8')

    p = base / 'add.php'
    s = p.read_text(encoding='utf-8')
    s = s.replace('class="module-form"', 'class="module-form"')
    s = re.sub(r'<h1>.*?</h1>', '<div class="page-header"><h1>Add ' + label + '</h1></div>', s, count=1, flags=re.S)
    s = re.sub(r'<form method="POST"[^>]*>', '<div class="form-card"><form method="POST" action="">', s, count=1)
    s = s.replace('</form>', '</form></div>', 1)
    s = s.replace('<button type="submit" class="submit">', '<button type="submit" class="submit">', 1)
    s = re.sub(r'<p>\s*<button type="submit" class="submit">(.*?)</button>\s*<a href="index.php" class="cancel">(.*?)</a>\s*</p>', '<div class="form-actions">\n            <button type="submit" class="submit">\\1</button>\n            <a href="index.php" class="cancel">\\2</a>\n        </div>', s, count=1, flags=re.S)
    s = s.replace('<body>', '<body>\n<?php include "../includes/sidebar.php"; ?>\n\n<div class="main">\n    <div class="page-content">', 1)
    s = s.replace('</body>', '    </div>\n</div>\n</body>', 1)
    p.write_text(s, encoding='utf-8')

    p = base / 'edit.php'
    s = p.read_text(encoding='utf-8')
    s = re.sub(r'<h1>.*?</h1>', '<div class="page-header"><h1>Edit ' + label + '</h1></div>', s, count=1, flags=re.S)
    s = s.replace('<div class="form-container">', '<div class="form-card">', 1)
    s = re.sub(r'<form method="POST"[^>]*>', '<form method="POST" class="module-form">', s, count=1)
    s = s.replace('<button class="btn" type="submit">', '<button class="submit" type="submit">', 1)
    s = s.replace('<body>', '<body>\n<?php include "../includes/sidebar.php"; ?>\n\n<div class="main">\n    <div class="page-content">', 1)
    s = s.replace('</body>', '    </div>\n</div>\n</body>', 1)
    p.write_text(s, encoding='utf-8')

    p = base / 'view.php'
    s = p.read_text(encoding='utf-8')
    s = re.sub(r'<h1>.*?</h1>', '<div class="page-header"><h1>' + label + ' Details</h1><a href="index.php" class="back">Back to ' + mod.capitalize() + '</a></div>', s, count=1, flags=re.S)
    s = re.sub(r'<body>.*?</body>', lambda m: re.sub(r'<p>\s*<strong>(.*?)</strong>\s*(.*?)\s*</p>', lambda m2: '<div class="card details-card"><div class="info-grid"><div class="info-box"><label>' + m2.group(1) + '</label><strong>' + m2.group(2).strip() + '</strong></div></div></div>', m.group(0), flags=re.S), m.group(0), count=1, flags=re.S), s, count=1)
    s = s.replace('<body>', '<body>\n<?php include "../includes/sidebar.php"; ?>\n\n<div class="main">\n    <div class="page-content">', 1)
    s = s.replace('</body>', '    </div>\n</div>\n</body>', 1)
    s = s.replace('<a href="index.php" class="cancel">', '<a href="index.php" class="back">', 1)
    p.write_text(s, encoding='utf-8')

print('Updated module page wrappers and button classes.')
