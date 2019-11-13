import React from "react";
import NavBar from "./Components/Navbar/NavBar";
import Profile from "./Components/Profile/Profile.component";

// import example from '../../public/example.json';

import Axios from "axios";
import { string } from "postcss-selector-parser";

class App extends React.Component {
  constructor() {
    super();

    this.state = {
      profile: []
    };
  }

  componentDidMount() {
    Axios.get("./example.json")
      .then(res => this.setState({ profile: res.data }))
      .catch(err => console.log(err));
  }

  change = (profileId, rowID, criteriaID, criteriaName, value) => {
    let copyState = this.state.profile;

    copyState
      .filter(checkProfileId => checkProfileId.id === profileId)
      .map(profile =>
        profile.all
          .filter(checkAllId => checkAllId.id === rowID)
          .map(all =>
            all.list
              .filter(checkCriteriaId => checkCriteriaId.id === criteriaID)
              .map(criteria => {
                criteria[criteriaName] = value;
              })
          )
      );
    this.setState({ profile: copyState });
    console.log("Check array if state is changed")
    console.log(this.state.profile)
  };

  render() {
    return (
      <div>
        <NavBar />
        {this.state.profile.map(data => (
          <Profile
            key={data.id}
            id={data.id}
            name={data.name}
            position={data.position}
            all={data.all}
            change={this.change}
          />
        ))}
      </div>
    );
  }
}

export default App;
