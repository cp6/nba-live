#!/usr/bin/env python3
"""Refactor constructor-fetch NBA endpoint classes to explicit fetch() methods."""

from __future__ import annotations

import re
from pathlib import Path

SKIP = {
    'NBABase.php',
    'NBAApiException.php',
    'NBAStandings.php',
    'NBABoxScoreFilters.php',
    'NBADashFilters.php',
    'NBATeamDashFilters.php',
    'NBAPlayerDashFilters.php',
    'NBALeagueDashFilters.php',
}

HTTP_USE = 'use Corbpie\\NBALive\\Http\\NbaHttpClientInterface;'
FETCHABLE_USE = 'use Corbpie\\NBALive\\Contracts\\FetchableEndpoint;'


def extract_method(content: str, start: int) -> tuple[str, int] | None:
    brace = content.find('{', start)
    if brace == -1:
        return None

    depth = 0
    i = brace
    while i < len(content):
        if content[i] == '{':
            depth += 1
        elif content[i] == '}':
            depth -= 1
            if depth == 0:
                return content[start : i + 1], i + 1
        i += 1

    return None


def ensure_use(content: str, use_line: str) -> str:
    if use_line in content:
        return content

    namespace_end = content.find('namespace Corbpie\\NBALive;')
    insert_at = content.find('\n', namespace_end) + 1
    return content[:insert_at] + '\n' + use_line + content[insert_at:]


def add_fetchable_interface(content: str, class_name: str) -> str:
    if 'implements FetchableEndpoint' in content:
        return content

    return re.sub(
        rf'(final class {class_name} extends NBABase)',
        r'\1 implements FetchableEndpoint',
        content,
        count=1,
    )


def build_constructor_call(params: str) -> str:
    params = params.strip()
    if params == '':
        return '$this->fetch();'

    args = []
    for part in params.split(','):
        part = part.strip()
        if not part or 'NbaHttpClientInterface' in part:
            continue
        name = part.split('=')[0].strip().lstrip('$')
        args.append(f'${name}')

    if not args:
        return '$this->fetch();'

    return '$this->fetch(' + ', '.join(args) + ');'


def append_http_client_param(params: str) -> str:
    params = params.strip()
    if 'NbaHttpClientInterface' in params:
        return params
    if params == '':
        return '?NbaHttpClientInterface $httpClient = null'
    return params + ', ?NbaHttpClientInterface $httpClient = null'


def refactor_file(path: Path) -> bool:
    content = path.read_text()

    if 'public function fetch(' in content or 'function __construct' not in content or 'ApiCall' not in content:
        return False

    match = re.search(r'public function __construct\s*\(', content)
    if not match:
        return False

    method_chunk = extract_method(content, match.start())
    if method_chunk is None:
        print(f'  skip (parse fail): {path.name}')
        return False

    method_text, _ = method_chunk
    sig_match = re.search(r'public function __construct\s*\((.*?)\)\s*\{', method_text, re.S)
    if not sig_match:
        print(f'  skip (sig fail): {path.name}')
        return False

    params = sig_match.group(1).strip()
    body = method_text[sig_match.end() : -1].rstrip()

    if 'return ' not in body:
        body += '\n\n        return ' + ('$this->data;' if '$this->data' in body else '[];')

    fetch_method = f'    public function fetch({params}): array\n    {{\n{body}\n    }}'
    new_params = append_http_client_param(params)
    fetch_call = build_constructor_call(params)
    new_constructor = (
        f'    public function __construct({new_params})\n'
        f'    {{\n'
        f'        parent::__construct($httpClient);\n'
        f'        {fetch_call}\n'
        f'    }}'
    )

    new_content = content.replace(method_text, fetch_method + '\n\n' + new_constructor)
    class_match = re.search(r'final class (\w+)', new_content)
    if class_match:
        new_content = add_fetchable_interface(new_content, class_match.group(1))

    new_content = ensure_use(new_content, HTTP_USE)
    new_content = ensure_use(new_content, FETCHABLE_USE)
    path.write_text(new_content)
    return True


def main() -> None:
    changed = 0
    for path in sorted(Path('src').glob('*.php')):
        if path.name in SKIP:
            continue
        if refactor_file(path):
            print(f'  refactored: {path.name}')
            changed += 1
    print(f'Done. Refactored {changed} files.')


if __name__ == '__main__':
    main()
