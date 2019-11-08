import React from "react";
import NavBar from "./Components/NavBar";
// import profilis from "../SampleJSON/example.json";
// import axios from 'axios';
import Profile from "./Components/Profile.component";
import Axios from "axios";

class App extends React.Component {
  constructor() {
    super();

    this.state = {
      profile: []
    };
  }

  componentDidMount() {
    // this.setState({ profile: profilis });
    Axios.get("./example.json")
    .then(res => this.setState({profile: res.data}))
  }

  render() {
    return (
      <div>
        <NavBar />
        {/* {console.log(this.state.profile)} */}
        {this.state.profile.map((data, index) => (
          <Profile
            key={index}
            name={data.name}
            position={data.position}
            // experience={data.experience}
            // technicalSkills={data.technicalSkills}
            // responsibilities={data.responsibilities}
            // english={data.english}
            // competencies={data.competencies}
            all={data.all}
          />
        ))}
      </div>
    );
  }
}

export default App;
