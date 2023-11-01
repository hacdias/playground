export default function matchAll(text: string, pattern: RegExp) {
  const matches = [];
  let match;
  do {
    match = pattern.exec(text);
    if (match) {
      matches.push(match);
    }
  } while (match);
  return matches;
}
