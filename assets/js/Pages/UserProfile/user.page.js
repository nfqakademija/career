import React from "react";
import "./user.style.scss";
import Axios from "axios";
import MountUserProfile from "../../Components/MountUserProfile/mountProfile.comp";
import { connect } from "react-redux";
import { setCareerFormId, setAnswers } from "../../Actions/action";

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
      })
      .catch(err => console.log(err));
  }

  render() {
    if (this.state.userProfile.length === 0) {
      return <h1>Loading...</h1>;
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
  onSetAnswers: answers => dispatch(setAnswers(answers))
});

export default connect(mapStateToProps, mapDispatchToProps)(User);
