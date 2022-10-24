# InfinIdea's common regexes

## Email :

(regex that allow emails with up to 200 characters and which is secure against SQL injection)

```regex
    ^[a-zA-Z0-9._%+-]{1,100}@[a-zA-Z0-9.-]{1,80}\.[a-zA-Z]{2,4}$
```

## Password :

(regex that allow passwords with up to 200 characters with any character)

```regex
    ^.{1,200}$
```

## Username :

(regex that allow usernames with up to 18 characters with letters, numbers, dashes and underscores)

```regex
    ^[a-zA-Z0-9_-]{1,18}$
```

## Surname :

(regex that allow surnames with up to 18 characters with letters, dashes and spaces)

```regex
    ^[a-zA-Z -]{1,18}$
```

## Comments :

(regex that allow comments with up to 1000 characters with any character)

```regex
    ^.{1,1000}$
```

## Article title :

(regex that allow article titles with up to 50 chars with every character)

```regex
    ^.{1,50}$
```

## Article description :

(regex that allow article descriptions with up to 200 chars with every character)

```regex
    ^.{1,200}$
```

## Article content :

(regex that allow article contents with up to 10000 chars with every character)

```regex
    ^.{1,10000}$
```

## Article tags :

(regex that allow article tags with up to 1000 characters, with letters, numbers, dashes, underscores, brackets and
commas)

```regex
    ^[a-zA-Z0-9_-,\[\]]{1,1000}$
```