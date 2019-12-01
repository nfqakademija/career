import React from "react";
import NavBar from "./Components/Navbar/NavBar";
import { Switch, Route } from "react-router-dom";
import HomePage from "./Pages/HomePage/HomePage.page";
import ProfilePage from "./Pages/ProfilePage/ProfilePage.page";
import HrProfiles from "./Pages/HrPage/hrPage.page";
import Footer from './Components/Footer/Footer.comp';
import Login from './Pages/Login/Login.page';

class App extends React.Component {
  render() {
    return (
      <div className="app">
        <NavBar />
        <Switch>
          <Route exact path="/" component={HomePage} />
          
          <Route path="/profiles" component={ProfilePage} />
          <Route path="/hrprofiles" component={HrProfiles} />

          <Route path="/login" component={Login} />
        </Switch>
        <Footer />
        {/* {console.log(route.path)} */}
      </div>
    );
  }
}

export default App;
