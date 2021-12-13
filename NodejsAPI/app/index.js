const express = require(`express`)
const cookieParser = require(`cookie-parser`)
const logger = require(`morgan`)
const session = require(`express-session`)
const cors = require(`cors`)
const { authenticate } = require(`./util`)

const passport = require("passport")
require("./mssqldb")
require("./mongoose")
const store = require(`./passport`)(session)

// Here, you should require() your mssqldb, mongoose, and passport setup files that you create
//const mssqldb = require(`mssqldb`)
// Here, you should require() your routers so you can use() them below

const userRouter = require(`./routes/user`)
const taskRouter = require(`./routes/tasks`)
const authRouter = require(`./routes/auth`)

const app = express()

// These lines are provided for you.
app.use(cors({
    origin: process.env.CLIENT_ORIGIN,
    credentials: true
}))// CORS will allow a front end specified in the .env to have access to restricted resources.
app.use(logger(`dev`)) // This line is for having pretty logs for each request that your API receives.
app.use(express.json()) // This line says that if a request has a body, that your api should assume it's going to be json, and to store it in req.body
app.use(express.urlencoded({ extended: false })) // this line says that if there's any URL data, that it should not use extended mode.
app.use(cookieParser()) // This line says that if there are any cookies, that your app should store them in req.cookies

// Here is where you should use the `express-session` middleware
const sess = {
    secret: process.env.SESSION_SECRET,
    name: "it210_session",
    resave: false,
    saveUninitialized: true,
    cookie: {maxage: 604800000},
    store
}

if (app.get('env') === 'production') {
    app.set('trust proxy', 1)// trust first proxy
    sess.cookie.secure = true // serve secure cookies
    sess.cookie.sameSite = 'none'
}

app.use(session(sess))
app.use(passport.initialize())
app.use(passport.session())

// Here is where you should assign your routers to specific routes. Make sure to authenticate() the routes that need authentication.
app.use(`/api/v1/user`, authenticate, userRouter)
app.use(`/api/v1/tasks`, authenticate, taskRouter)
app.use(`/api/v1/auth`, authRouter)

module.exports = app