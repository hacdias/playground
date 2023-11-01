import slugify from 'slugify';

export default function makeSlug(text: string) {
  return slugify(text, {
    strict: true,
    lower: true
  });
}
