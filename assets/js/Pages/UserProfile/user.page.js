import React from "react";
import "./user.style.scss";
import Axios from "axios";
import { connect } from "react-redux";

class User extends React.Component {
  constructor() {
    super();

    this.state = {
      profile: []
    };
  }
  componentDidMount() {
    Axios.get(`/api/forms/${this.props.userId}`)
      .then(res => {
        // console.log(res.data.profile);
        this.setState({ profile: res.data.profile });
      })
      .catch(err => console.log(err));
  }

  render() {

    return (
      <div className="user">
        <h1>{this.state.profile.professionTitle}</h1>
        {/* <table>
          <thead>
            <tr>
              <th></th>
              <th>Criteria</th>
              <th>Self Evaluation</th>
              <th>Comments</th>
              <th>Team lead evaluation</th>
              <th>Overall</th>
            </tr>
          </thead> */}
          {/* <tbody> */}
            {/* {console.log(this.state.profile.criteriaList)} */}
            {/* </tbody> */}
        {/* </table> */}
      </div>
    );
  }
}

const mapStateToProps = state => ({
  userId: state.user.userId
});

export default connect(mapStateToProps, null)(User);
