import React from "react";
import { connect } from "react-redux";
import Profile from "../Profile.v2/profile.comp";
import "./mountProfile.style.scss";
import Axios from "axios";
import { setChoiceList, restartAnswers } from "../../Actions/action";

class MountProfile extends React.Component {
  constructor() {
    super();

    this.state = {
      showProfile: []
    };
  }

  componentDidMount() {
    Axios.get(`/api/answers/${this.props.formId}`)
      .then(res => {
          if(res.data === 404){
            this.props.onRestartAnswers();
            console.log(res)
            console.log("BAD response")
          }else{
            const data = res.data;
            this.props.onSetChoiceList(data.list);
            console.log(res)
            console.log("GOoooood response")
          }
      })
      .catch(err => console.log(err));
  }

  toogle = i => {
    if (this.state.showProfile.includes(i)) {
      const array = [...this.state.showProfile];
      const index = array.indexOf(i);
      array.splice(index, 1);
      this.setState({ showProfile: array });
    } else {
      this.setState({ showProfile: this.state.showProfile.concat(i) });
    }
  };

  submit = () => {
    let obj = {
      formId: this.props.formId,
      answers: this.props.answers
    };

    console.log("i post this: ");
    console.log(obj);

    if (this.props.answers.length === 0) {
      alert("You haven't changed anything.");
    } else {
      Axios.post("/api/answers", {
        data: obj
      })
        .then(function(response) {
          // console.log(response.statusText);
          alert("Created successfully");
        })
        .catch(function(error) {
          console.log(error);
          alert("Something went wrong... Try again later");
        });

      this.props.onRestartAnswers();
    }
  };

  render() {
    return (
      <div className="mountProfile">
        <div className="u-flexCenter">
          <h4>Name: {this.props.name}</h4>
          <h4>Position: {this.props.data.profile.professionTitle}</h4>
        </div>

        <div className="profile">
          <h4 className="careerProfile">Career Profile</h4>
          {this.props.data.profile.criteriaList.map((data, index) => {
            return (
              <React.Fragment key={index}>
                <h4 className="competence" onClick={() => this.toogle(index)}>
                  {data.competence}
                </h4>
                {this.state.showProfile.includes(index) ? (
                  <Profile criteriaList={data.criteria} />
                ) : null}
              </React.Fragment>
            );
          })}
          <button onClick={this.submit}>Save</button>
        </div>
      </div>
    );
  }
}

const mapStateToProps = state => ({
  userId: state.user.userId,
  name: state.user.name,
  formId: state.user.formId,
  answers: state.trackUserChanges.choiceAnswers
});

const mapDispatchToProps = dispatch => ({
  onSetChoiceList: choiceList => dispatch(setChoiceList(choiceList)),
  onRestartAnswers: () => dispatch(restartAnswers())
});

export default connect(mapStateToProps, mapDispatchToProps)(MountProfile);
