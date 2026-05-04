import phpServer from 'php-server';

// Basic usage
const server = await phpServer({
  port: 8080,
  base: './public'
});

console.log(`Running at ${server.url}`);
