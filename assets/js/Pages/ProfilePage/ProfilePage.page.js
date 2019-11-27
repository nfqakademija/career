import React from "react";
import Profile from "../../Components/Profile/Profile.competence.comp";
import { setProfilesList } from "../../Actions/action";
import Axios from "axios";
import { connect } from "react-redux";
import "./ProfilePage.style.scss";

class ProfilePage extends React.Component {
  componentDidMount() {
    Axios.get("./example.json")
      .then(res => this.props.onSetProfileList(res.data))
      .catch(err => console.log(err));
  }

  change = (profileId, rowID, criteriaID, criteriaName, value) => {
    let copyState = this.props.profilesList;

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
    this.props.onSetProfileList(copyState);
    console.log("Check array if state is changed");
  };

  render() {
    return (
      <div className="profilePage">
        {this.props.profilesList.map(data => (
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

const mapStateToProps = state => ({
  profilesList: state.profilesList.profiles
});
const mapDispatchToProps = dispatch => ({
  onSetProfileList: profile => dispatch(setProfilesList(profile))
});

export default connect(mapStateToProps, mapDispatchToProps)(ProfilePage);
