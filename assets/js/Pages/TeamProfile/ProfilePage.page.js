import React from "react";
// import { setProfilesList } from "../../Actions/action";
import Axios from "axios";
import { connect } from "react-redux";
import "./ProfilePage.style.scss";
import ProfileButtons from "../../Components/ProfileButtons/ProfileButtons.comp";
import CompetenceView from "../../Components/CompetenceView/competenceView.comp";
import { restartAnswersUserSide } from "../../Actions/action";
import { getUserAnswer } from "../../thunk/getUserAnswer";

class ProfilePage extends React.Component {
  constructor() {
    super();

    this.state = {
      profileNames: [],
      fullProfile: []
    };
  }
  componentDidMount() {
    Axios.get(`/api/teams/${this.props.teams[0].id}/users`)
      .then(res => {
        console.log(res.data.list);
        this.setState({ profileNames: res.data.list });
      })
      .catch(err => console.log(err));
  }

  selectedUser = id => {
    Axios.get(`/api/forms/${id}`)
      .then(res => {
        this.setState({ fullProfile: res.data });
        this.props.onGetUserAnswer(res.data.id)
      })
      .catch(err => console.log(err));
  };

  render() {
    return (
      <div className="profilePage">
        {this.state.profileNames.map(profileNames => (
          <ProfileButtons
            key={profileNames.id}
            id={profileNames.id}
            name={profileNames.firstName + " " + profileNames.lastName}
            handle={this.selectedUser}
          />
        ))}
        <div>
          {this.state.fullProfile.length === 0 ? null : (
            <CompetenceView
              name={this.state.fullProfile.userView.firstName}
              position={this.state.fullProfile.profile.professionTitle}
              competence={this.state.fullProfile.profile.criteriaList}
            />
          )}
        </div>
      </div>
    );
  }
}

const mapStateToProps = state => ({
  teams: state.user.teams
});

const mapDispatchToProps = dispatch => ({
  onRestartAnswersUserSide: () => dispatch(restartAnswersUserSide()),
  onGetUserAnswer: formId => dispatch(getUserAnswer(formId))
});

export default connect(mapStateToProps, mapDispatchToProps)(ProfilePage);
