import { restartAnswers, isActionCalled } from "../Actions/action";
import Axios from "axios";

export const submitAnswers = (api, formId, answers, comments) => dispatch => {
  let obj = {
    formId: formId,
    choiceAnswers: answers,
    commentAnswers: comments
  };
  console.log(obj)
  if (answers.length === 0 && comments.length === 0) {
    alert("You haven't changed anything.");
  } else {
    Axios.post(`${api}`, {
      data: obj
    })
      .then(function(response) {
        alert("Created successfully");
      })
      .catch(function(error) {
        console.log(error);
        alert("Something went wrong... Try again later");
      });

    dispatch(restartAnswers());
    dispatch(isActionCalled(false));
  }
};
