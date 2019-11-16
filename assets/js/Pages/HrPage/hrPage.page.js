import React from "react";
import Axios from "axios";

class HrPage extends React.Component {
  constructor() {
    super();

    this.state = {
      profiles: []
    };
  }

  componentDidMount() {
    Axios.get("/api/competence/list")
      .then(res => this.setState({ profiles: res.data }))
      .catch(err => console.log(err));
  }

  render() {
    return (
      <div>
        {/* {this.state.profiles.map(data => )} */}
        {console.log(this.state.profiles)}
      </div>
    );
  }
}

export default HrPage;
