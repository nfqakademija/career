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
    Axios.get(`/api/forms/${this.props.userId}`, {
      headers: { Authorization: `Bearer ${this.props.token}` }
    })
      .then(res => {
        this.props.onSetCareerFormId(res.data.id);
        this.setState({ userProfile: res.data });
      })
      .catch(err => console.log(err));
  }

  render() {
    if (this.state.userProfile.length === 0) {
      return (
        <div className="user">
          <h1>Loading...</h1>
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
  userId: state.user.userId,
  token: state.token.token
});

const mapDispatchToProps = dispatch => ({
  onSetCareerFormId: formId => dispatch(setCareerFormId(formId))
});

export default connect(mapStateToProps, mapDispatchToProps)(User);
