const express = require(`express`)
const passport = require("passport")
const router = express.Router()

// using google authentication to authenticate a user 
router.get('/google',
  passport.authenticate('google', { scope: ['https://www.googleapis.com/auth/plus.login',
  'https://www.googleapis.com/auth/userinfo.email']}
  ));
//redirects to the the home page once the user is authenticated
router.get('/google/callback', 
  passport.authenticate('google', { failureRedirect: '/login' }),
  function(req, res) {
      try {
        req.session.save()
        res.redirect(process.env.CLIENT_ORIGIN);
      } catch (error) {
          console.error(error)
          res.status(500).send("500 error")
      }
    
  });
  //logs the user out and redirects to home page
router.get(`/logout`, async (req,res) => {
    req.session.destroy()
    req.logout()
    res.redirect(process.env.CLIENT_ORIGIN)
})
module.exports = router