const quotes = [
  {
    quote: "Love yourself first and everything else falls into place.",
    author: "Lucille Ball",
  },
  {
    quote: "Never regret anything that made you smile.",
    author: "Mark Twain",
  },
  {
    quote: "All limitations are self-imposed.",
    author: "",
  },
  {
    quote: "All limitations are self-imposed.",
    author: "Oliver Wendell Holmes",
  },
  {
    quote: "Problems are not stop signs, they are guidelines.",
    author: "Robert H. Schiuller",
  },
  {
    quote: "Don't sit down and wait for the opportunities to come. Get up and make them.",
    author: "Madam C.J Walker",
  },
  {
    quote: "Life is 10% what happens to you and 90% how you react to it.",
    author: "Charles R. Swindoll",
  },
  {
    quote: "Doubt kills more dreams than failure ever will.",
    author: "Suzy Kassem",
  },
  {
    quote: "It always seems impossible until its done.",
    author: "Nelson Mandela",
  },
  {
    quote: "Success is a journey not a destination.",
    author: "Ben Sweetland",
  }
];

const quote = document.querySelector("#quote-form span:first-of-type");
const author = document.querySelector("#quote-form span:last-of-type");
const todaysQuote = quotes[Math.floor(Math.random() * quotes.length)];

quote.innerHTML = todaysQuote.quote;
author.innerHTML = todaysQuote.author;

