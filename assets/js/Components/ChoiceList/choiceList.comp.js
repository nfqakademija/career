import React from "react";
import { connect } from "react-redux";
import { setAnswers, removeAnswer } from "../../Actions/action";

class ChoiceList extends React.Component {
  render() {
    const { choices } = this.props;
    let answer = "Not answered";

    choices.forEach(element => {
      if (this.props.choiceList.includes(element.id)) {
        answer = element.title;
      }
    });

    return (
      <select defaultValue={answer}>
        {answer === "Not answered"? <option value="Not answered">--Not answered--</option>:null}
        {choices.map(choice => (
          <option
            onClick={() =>
              this.props.onSetAnswers(this.props.criteriaId, choice.id)
            }
            key={choice.id}
            value={choice.title}
          >
            {choice.title}
          </option>
        ))}
      </select>
    );
  }
}

const mapStateToProps = state => ({
  answers: state.trackUserChanges.choiceAnswers,
  choiceList: state.user.choiceList
});

const mapDispatchToProps = dispatch => ({
  onSetAnswers: (criteriaId, choiceId) =>
    dispatch(setAnswers(criteriaId, choiceId))
});

export default connect(mapStateToProps, mapDispatchToProps)(ChoiceList);
