// import React from "react";
// import NavBar from "./Components/Navbar/NavBar";
// import Profile from "./Components/Profile/Profile.component";
// import { setSelectedProfileButton, setProfilesList } from "./Actions/action";

// // import example from '../../public/example.json';

// import Axios from "axios";
// import { connect } from "react-redux";
// // import { string } from "postcss-selector-parser";

// class App extends React.Component {
//   componentDidMount() {
//     Axios.get("./example.json")
//       .then(res => this.props.onSetProfileList(res.data))
//       .catch(err => console.log(err));
//   }

//   change = (profileId, rowID, criteriaID, criteriaName, value) => {
//     let copyState = this.props.profilesList;

//     copyState
//       .filter(checkProfileId => checkProfileId.id === profileId)
//       .map(profile =>
//         profile.all
//           .filter(checkAllId => checkAllId.id === rowID)
//           .map(all =>
//             all.list
//               .filter(checkCriteriaId => checkCriteriaId.id === criteriaID)
//               .map(criteria => {
//                 criteria[criteriaName] = value;
//               })
//           )
//       );
//     this.props.onSetProfileList(copyState);
//     console.log("Check array if state is changed");
//   };

//   render() {
//     return (
//       <div>
//         <NavBar />
//         {this.props.profilesList.map(data => (
//           <Profile
//             key={data.id}
//             id={data.id}
//             name={data.name}
//             position={data.position}
//             all={data.all}
//             change={this.change}
//           />
//         ))}
//       </div>
//     );
//   }
// }

// const mapStateToProps = state => ({
//   selectedProfile: state.profileId.profileId, //selected profile id
//   profilesList: state.profilesList.profiles
// });
// const mapDispatchToProps = dispatch => ({
//   onSetSelectedProfile: profileId => dispatch(setSelectedProfileButton(profileId)), //selected profile
//   onSetProfileList: profile => dispatch(setProfilesList(profile))
// });

// export default connect(mapStateToProps, mapDispatchToProps)(App);

import React from "react";
import NavBar from "./Components/Navbar/NavBar";
import { Switch, Route } from "react-router-dom";

// import HomePage from "./Pages/HomePage/HomePage.page";
import HomePage from './Components/LogIn/ValidatedLoginForm'
import ProfilePage from "./Pages/ProfilePage/ProfilePage.page";

class App extends React.Component {
  render() {
    return (
      <div>
        <NavBar />
        <Switch>
          <Route exact path="/" component={HomePage} />
          <Route path="/profiles" component={ProfilePage} />
        </Switch>
      </div>
    );
  }
}

export default App;
