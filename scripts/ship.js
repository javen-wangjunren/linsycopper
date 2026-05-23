const { spawnSync } = require('node:child_process');

function run(cmd, args) {
  const res = spawnSync(cmd, args, { stdio: 'inherit' });
  if (res.error) throw res.error;
  if (typeof res.status === 'number' && res.status !== 0) process.exit(res.status);
}

function runQuiet(cmd, args) {
  const res = spawnSync(cmd, args, { stdio: 'ignore' });
  if (res.error) throw res.error;
  return typeof res.status === 'number' ? res.status : 1;
}

function parseMsgFromArgv(argv) {
  for (let i = 0; i < argv.length; i += 1) {
    const a = String(argv[i] || '');
    if (a.startsWith('--msg=')) return a.slice('--msg='.length);
    if (a === '--msg' && argv[i + 1]) return String(argv[i + 1]);
    if (a.startsWith('-m=')) return a.slice('-m='.length);
    if (a === '-m' && argv[i + 1]) return String(argv[i + 1]);
  }
  return '';
}

const msg = (
  process.env.npm_config_msg ||
  parseMsgFromArgv(process.argv.slice(2)) ||
  ''
).trim();

if (!msg) {
  process.stderr.write('Usage: npm run ship -- --msg="your commit message"\n');
  process.exit(1);
}

run('npm', ['run', 'build']);
run('git', ['add', '-A']);

const hasStagedChanges = runQuiet('git', ['diff', '--cached', '--quiet']) !== 0;
if (!hasStagedChanges) {
  process.stdout.write('No changes to commit.\n');
  process.exit(0);
}

run('git', ['commit', '-m', msg]);
run('git', ['push', 'origin', 'main']);
