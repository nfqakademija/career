import React from "react";
import "./user.style.scss";
import Axios from "axios";
import MountUserProfile from "../../Components/MountUserProfile/mountProfile.comp";
import { connect } from "react-redux";
import { setCareerFormId } from "../../Actions/action";

class User extends React.Component {
  constructor() {
    super();

    this.state = {
      userProfile: []
    };
  }
  componentDidMount() {
    Axios.get(`/api/forms/${this.props.userId}`)
      .then(res => {
        this.props.onSetCareerFormId(res.data.id);
        this.setState({ userProfile: res.data });
        console.log(res.data);
      })
      .catch(err => console.log(err));
  }

  render() {
    console.log(this.state.userProfile);
    if (this.state.userProfile.length === 0) {
      return (
        <div className="user">
          <h1>No data about your profile.</h1>
        </div>
      );
    }
    return (
      <div className="user">
        <MountUserProfile data={this.state.userProfile} />
      </div>
    );
  }
}

const mapStateToProps = state => ({
  userId: state.user.userId
});

const mapDispatchToProps = dispatch => ({
  onSetCareerFormId: formId => dispatch(setCareerFormId(formId)),
  // onSetAnswers: answers => dispatch(setAnswers(answers))
});

export default connect(mapStateToProps, mapDispatchToProps)(User);
