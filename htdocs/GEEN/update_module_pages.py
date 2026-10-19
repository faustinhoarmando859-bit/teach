from pathlib import Path
import re

root = Path(r'd:\xampp\htdocs\GEEN')
modules = ['students', 'teachers', 'classes', 'subjects', 'results', 'attendance', 'fees']


def replace_body(page: Path, page_title: str, title: str, fields: str = ''):
    text = page.read_text(encoding='utf-8')
    body_match = re.search(r'<body>(.*?)</body>', text, re.S)
    if not body_match:
        raise ValueError(f'No body in {page}')
    body = body_match.group(1)

    if '<div class="main">' in body:
        return

    if page.name == 'index.php':
        title_label = title
        action_label = title.rsplit('s', 1)[0] if title.endswith('s') else title
        extra = f'''\n\n<div class="main">\n    <div class="page-content">\n        <div class="page-header">\n            <h1>{title}</h1>\n            <div class="header-actions">\n                <a href="add.php" class="add-btn">+ Add {action_label}</a>\n                <a href="../dashboard.php" class="back">Back to Dashboard</a>\n            </div>\n        </div>\n'''
    elif page.name == 'add.php' or page.name == 'edit.php':
        extra = f'''\n\n<div class="main">\n    <div class="page-content">\n        <div class="page-header">\n            <h1>{page_title}</h1>\n        </div>\n'''
    else:
        extra = f'''\n\n<div class="main">\n    <div class="page-content">\n        <div class="page-header">\n            <h1>{page_title}</h1>\n            <a href="index.php" class="back">Back to {title}</a>\n        </div>\n'''

    if page.name == 'index.php':
        body = re.sub(r'\s*<h1>.*?</h1>\s*<a href="add\.php".*?</a>\s*<a href="\.\./dashboard\.php".*?</a>', '', body, count=1, flags=re.S)
        body = re.sub(r'<div class="table-wrapper"><table', '<div class="table-panel"><div class="table-wrapper"><table', body, count=1)
        body = re.sub(r'</table>\s*</div>', '</table></div></div>', body, count=1)
        body = re.sub(r'class="button"', 'class="view-btn"', body)
        body = re.sub(r'class="button delete"', 'class="delete-btn"', body)
        body = re.sub(r'class="button add-button"', 'class="add-btn"', body)
        body = re.sub(r'class="add-button"', 'class="add-btn"', body)
    elif page.name == 'add.php':
        body = re.sub(r'<h1>.*?</h1>', '', body, count=1, flags=re.S)
        body = re.sub(r'<form\s+([^>]*)>', '<div class="form-card"><form \\1>', body, count=1)
        body = body.replace('</form>', '</form></div>', 1)
        body = re.sub(r'<p>\s*(<button\s+type="submit"[^>]*>.*?</button>)\s*(<a href="index\.php"[^>]*>.*?</a>)\s*</p>', '<div class="form-actions">\\1\\2</div>', body, count=1, flags=re.S)
        body = re.sub(r'<p>\s*(<button[^>]*>.*?</button>)\s*(<a href="index\.php"[^>]*>.*?</a>)\s*</p>', '<div class="form-actions">\\1\\2</div>', body, count=1, flags=re.S)
    elif page.name == 'edit.php':
        body = re.sub(r'<h1>.*?</h1>', '', body, count=1, flags=re.S)
        body = re.sub(r'<div class="form-container"', '<div class="form-card"', body, count=1)
        body = re.sub(r'<form\s+([^>]*)>', '<form \\1 class="module-form">', body, count=1)
        body = re.sub(r'<button class="btn" type="submit">', '<button class="submit" type="submit">', body, count=1)
        body = re.sub(r'<button class="btn"([^>]*)>', '<button class="submit"\\1>', body, count=1)
        body = re.sub(r'<form method="POST" class="module-form">', '<form method="POST" class="module-form">', body, count=1)
    elif page.name == 'view.php':
        body = re.sub(r'<h1>.*?</h1>', '', body, count=1, flags=re.S)
        body = re.sub(r'<p>\s*<strong>(.*?)</strong>\s*(.*?)\s*</p>', lambda m: '<div class="info-box"><label>' + m.group(1) + '</label><strong>' + m.group(2).strip() + '</strong></div>', body, flags=re.S)
        body = re.sub(r'<div class="info-box">(.*?)(?=</div>)', '<div class="info-box">\\1', body, flags=re.S)
        body = re.sub(r'(<div class="info-box">.*?</div>)\s*(<div class="info-box">.*?</div>)', '<div class="info-grid">\\1\\2</div>', body, count=1, flags=re.S)
        body = re.sub(r'<a href="index\.php" class="cancel">', '<a href="index.php" class="back">', body, count=1)
        body = body.replace(' | ', ' ')

    body = body.replace('?>\n\n<?php include "../includes/sidebar.php"; ?>', '?>\n\n<?php include "../includes/sidebar.php"; ?>', 1)
    new_body = extra + body + '\n    </div>\n</div>\n'
    text = text[:body_match.start()] + '<body>' + new_body + '</body>' + text[body_match.end():]
    page.write_text(text, encoding='utf-8')


for module in modules:
    for name, title in [('index.php', module.capitalize()), ('add.php', f'Add {module[:-1].capitalize()}'), ('edit.php', f'Edit {module[:-1].capitalize()}'), ('view.php', f'{module[:-1].capitalize()} Details')]:
        page = root / module / name
        if page.exists():
            replace_body(page, title, module.capitalize(), '')

print('Updated module pages.')
