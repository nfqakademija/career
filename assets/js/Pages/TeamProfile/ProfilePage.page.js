import React from "react";
// import { setProfilesList } from "../../Actions/action";
import Axios from "axios";
import { connect } from "react-redux";
import "./ProfilePage.style.scss";
import ProfileButtons from "../../Components/ProfileButtons/ProfileButtons.comp";
import CompetenceView from '../../Components/CompetenceView/competenceView.comp';

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
        // console.log(res.data.list);
        this.setState({ profileNames: res.data.list });
      })
      .catch(err => console.log(err));
  }

  selectedUser = id => {
    Axios.get(`/api/forms/${id}`)
      .then(res => {
        console.log(res.data)
        this.setState({ fullProfile: res.data });
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

export default connect(mapStateToProps, null)(ProfilePage);
