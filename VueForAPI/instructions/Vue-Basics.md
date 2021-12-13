# Vue Basics

## Components

A __Component__ is a bit of code that is ideally completely reusable and independent from all of the other code in your project. You should always strive to make your components completely reusable (meaning they have as few dependencies as possible). In Vue, they have it set up so that your component is in a single file ([Single-File Components](https://vuejs.org/v2/guide/single-file-components.html)).

We discussed earlier the different parts of these files. The `<script>` section is the most important for us in this project. This is where you tell the component what it is, what it has access to, and what it does.

Components in Vue have a wide range of capabilities that help with development. You'll be using __Props__, __Computed Properties__, __Async Computed Properties__ (which we'll need an npm package for), __The `data` object__, __The `methods` object__, and __The `mounted()` method__.

## Data Object (method)

The `data` property of a Vue Component should be a function that returns an object. That object can be thought of as a small database just for this component.

Vue takes everything in the `data` object and assigns it to the component's JavaScript object so they can be accessed using the `this` keyword. Then, in the template, you can access them using "mustache syntax", or double curly braces (`{{}}`). For example:

```html
<template>
  <div id='some-component'>
    <span>{{message}}</span>
  </div>
</template>

<script>
export default {
  name: `some-component`,
  data: () => ({
    message: `welcome to vue!`
  })
}
</script>
```

## Methods Object

The methods object is just like the `data` object, but for methods. Vue takes them and sticks them on `this`. That means you can do something like this:

```html
<template>
  <div id='some-component'>
    <button @click="showMessage"></button>
  </div>
</template>

<script>
export default {
  name: `some-component`,
  data: () => ({
    message: `welcome to vue!`,
  }),
  methods: {
    showMessage() {
      alert(this.message)
    },
  },
}
</script>
```

>Explanation: The `@` symbol is kinda hard to explain. Basically, it's syntactic sugar for the `v-on` directive, which is how you define events. In this case, `@click=""` is equivalent to `v-on:click=""`, which is equivalent to the native HTML `onclick=""` attribute.

## Computed Properties

You can define properties that are need-to-know, meaning they are really just a function that returns the value you want. Let's say we have a `<person>` component, and we have the birthday but not the age:

```js
export default {
  name: `person`,
  data: () => ({
    name: `John`,
    birthday: `10-10-1990`,
  }),
}
```

We can create a __Computed Property__ to get the age without having to store the age:

```js
export default {
  name: `person`,
  data: () => ({
    name: `John`,
    birthday: `10-10-1990`,
  }),
  computed: {
    age() {
      return Date.now() - new Date(this.birthday).getTime() / 31536000000 // age in years
    },
  },
}
```

Then we access it in the `<template>` like any other data property:

```html
<template>
  <div id='person'>
    <span>Name: {{name}}</span>
    <span>Age: {{age}}</span>
  </div>
</template>
```

## Props

Props is probably the most important tool when using components. This is how you give a component data, kind of like the parameters of a function. Let's say you had a component called `blue-button`. In the component's `.vue` file (probably named `BlueButton.vue`), there would be a `<template>`, `<script>`, and `<style>` tag that has all the information about it and any methods. Lastly, let's say that someone designed this component to take a prop, which is the method that should be executed when the button is clicked.

Now that we've defined our component, we need to use it. In some other `.vue` file, we can put this component into our `<template>` area using the following code:

```html
<blue-button></blue-button>
```

>Note: File names are written in "Pascal case" or "Capital Case" (every new word starts with a capital letter), and tags are written in "Kebab case" (words are all lower-case with hyphens between each word). The associated file for `<blue-button>` would be called `BlueButton.vue`, though I think this might have changed, and now I think you can just have the tag use the same casing: `<BlueButton />`, but I'm too lazy to check.

In the `<script>` section, you'll find some code that describes the component:

##### BlueButton.vue
```html
<template>
  <div id='blue-button'>
    <button @click='handleClick'>Click Me</button>
  </div>
</template>

<script>
export default {
  name: `blue-button`,
  props: {
    clickHandler: {
      type: Function,
      default: () => {},
    },
  },
}
</script>
```

From our other component, you can then give your `clickHandler` method to the `<blue-button>` using the following syntax:

##### OtherComponent.vue
```html
<template>
  <div id='other-component'>
    <blue-button clickHandler="myClickHandler"></blue-button>
  </div>
</template>

<script>
import BlueButton from './BlueButton.vue'

export default {
  name: `other-component`,
  components: {
    BlueButton,
  },
  methods: {
    myClickHandler() {
      alert(`You clicked the blue button!`)
    },
  },
}
</script>
```

## Importing and Exporting

JavaScript, along with many other coding languages, is constantly undergoing big changes to ease development. One more recent suggestion is that instead of using `module.exports = {}`, you should be able to use `export default {}` instead. This newer suggestion, along with many other suggestions, are added one step at a time, at a pretty slow pace. However, it's slow because so many tools depend on JavaScript, and adding new functionality means that newer applications (with the newer syntax) will not run on, for instance, older browsers that aren't built to be able to read that syntax. JavaScript is actually called EcmaScript, and therefore you'll see the word `ES5` and `ES5` thrown around, or maybe even `ESNext`, which is an unofficial collection of syntaxes that developers really like.

In order to make sure our application can run ANYWHERE, we use an npm package called `babel` to translate newer syntax into older syntax (And yes, it's a reference to the biblical Tower of Babel). Babel is capable of changing almost ANY of these newer sets of syntax into older JavaScript syntax. Part of the reason we're developing a website using Node.js is that when we run the site, Babel actually does some live translation for us. What you see in your files is not what the browser sees. To see what Babel does first-hand, run `npm run build` in a terminal and check the `dist` folder. That's your entire website, but translated into plain HTML, CSS, and ES5 JavaScript!

In a Vue project, you can use ES6 syntax instead of ES5 syntax. So this:

##### es5_export.js
```js
module.exports = {
  name: `daniel`,
  age: 25,
  country: `canada`,
}
```

##### es5_import.js
```js
const { name, age, country } = require(`./es5_export.js`)
```

is the same as this:

##### es6_export.js
```js
export default {
  name: `daniel`,
  age: 25,
  country: `canada`,
}
```

##### es6_import.js
```js
import { name, age, country } from './es6_export.js'
```

You can also export one `default` and multiple other things from a file:

##### es6_export2.js
```js
const wowza = `🤩`
export wowza

export default {
  name: `daniel`,
  age: 25,
  country: `canada`,
}
```

##### es6_import2.js
```js
import person, { wowza } from './es6_export2.js'
```

But keep in mind that the non-default exports need to be named variables.


