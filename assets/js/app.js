import React from "react";
import NavBar from "./Components/Navbar/NavBar";
import Profile from "./Components/Profile/Profile.component";

// import example from '../../public/example.json';

import Axios from 'axios';

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
    // this.setState({profile:example})
  }

  render() {
    return (
      <div>
        <NavBar />
        {this.state.profile.map((data, index) => (
          <Profile
            key={index}
            name={data.name}
            position={data.position}
            all={data.all}
          />
        ))}
      </div>
    );
  }
}

export default App;
