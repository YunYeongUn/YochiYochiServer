/**
 * @license
 * Copyright 2021 Google LLC. All Rights Reserved.
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * =============================================================================
 */

import "@tensorflow/tfjs-backend-webgl";
import "@tensorflow/tfjs-backend-webgpu";
// import * as mpPose from '@mediapipe/pose';

import * as tfjsWasm from "@tensorflow/tfjs-backend-wasm";

// console.log(`movenet${a}`);

import * as posedetection from "@tensorflow-models/pose-detection";

import { Camera } from "./camera";
import * as params from "./params";
import { setBackendAndEnvFlags } from "./util";

export default class MoveNet {
  constructor(cb) {
    console.log(cb);
    this.init(cb);
  }

  async init(cb) {
    tfjsWasm.setWasmPaths(
      `https://cdn.jsdelivr.net/npm/@tensorflow/tfjs-backend-wasm@${tfjsWasm.version_wasm}/dist/`
    );
    await posedetection.createDetector(
      posedetection.SupportedModels.MoveNet,
      "lightning"
    );
    this.camera = await Camera.setupCamera(params.STATE.camera);

    await setBackendAndEnvFlags(params.STATE.flags, params.STATE.backend);

    this.detector = await this.createDetector();

    await this.renderPrediction(this.camera, this.detector, this.coordArr, cb);
    // await this.app();
  }
  detector;
  camera;
  rafId;
  coordArr = [];

  async createDetector() {
    const modelConfig = posedetection.movenet.modelType.SINGLEPOSE_LIGHTNING;
    params.STATE.model = posedetection.SupportedModels.MoveNet;
    return posedetection.createDetector(params.STATE.model, modelConfig);
  }

  async renderPrediction(camera, detector, coordArr, cb) {
    async function renderResult() {
      if (camera.video.readyState < 2) {
        await new Promise((resolve) => {
          camera.video.onloadeddata = () => {
            resolve(video);
          };
        });
      }

      let poses = null;

      // Detector can be null if initialization failed (for example when loading
      // from a URL that does not exist).
      if (detector != null) {
        // Detectors can throw errors, for example when using custom URLs that
        // contain a model that doesn't provide the expected output.
        try {
          coordArr = [];

          poses = await detector.estimatePoses(camera.video, {
            maxPoses: params.STATE.modelConfig.maxPoses,
            flipHorizontal: false,
          });
        } catch (error) {
          detector.dispose();
          detector = null;
          alert(error);
        }
      }

      camera.drawCtx();

      // The null check makes sure the UI is not in the middle of changing to a
      // different model. If during model change, the result is from an old model,
      // which shouldn't be rendered.
      if (poses && poses.length > 0 && !params.STATE.isModelChanged) {
        coordArr = [];

        camera.drawResults(poses, coordArr);
        cb(coordArr);

        // console.log(poses);
        // for (const pose of poses) {
        //   // console.log(pose);
        //   pose.keypoints.forEach((keypoint) => [
        //   coordArr.push(keypoint)
        //   ])
        //   // console.log(coordArr.length);
        // }
        // console.log(coordArr)
      }
    }
    if (!params.STATE.isModelChanged) {
      await renderResult();
    }
    // console.log(this);
    const camera1 = this.camera;
    const detector1 = this.detector;
    const coordArr1 = this.coordArr;
    this.rafId = requestAnimationFrame(() =>
      this.renderPrediction(camera1, detector1, coordArr1, cb)
    );
  }

  // async app() {

  //   this.camera = await Camera.setupCamera(params.STATE.camera);

  //   // console.log(`camera${this.camera.video}`);

  //   await setBackendAndEnvFlags(params.STATE.flags, params.STATE.backend);

  //   this.detector = await this.createDetector();

  //   await this.renderPrediction();
  // };
}
// tfjsWasm.setWasmPaths(
//   `https://cdn.jsdelivr.net/npm/@tensorflow/tfjs-backend-wasm@${
//       tfjsWasm.version_wasm}/dist/`);

// let detector, camera;
// let rafId;
// let coordArr = [];

// async function createDetector() {
//   const modelConfig = posedetection.movenet.modelType.SINGLEPOSE_LIGHTNING;
//   params.STATE.model = posedetection.SupportedModels.MoveNet;
//     return posedetection.createDetector(params.STATE.model, modelConfig);
// }

// posedetection.createDetector(posedetection.SupportedModels.MoveNet, 'lightning');

// async function renderResult() {
//   if (camera.video.readyState < 2) {
//     await new Promise((resolve) => {
//       camera.video.onloadeddata = () => {
//         resolve(video);
//       };
//     });
//   }

//   let poses = null;

//   // Detector can be null if initialization failed (for example when loading
//   // from a URL that does not exist).
//   if (detector != null) {
//     // Detectors can throw errors, for example when using custom URLs that
//     // contain a model that doesn't provide the expected output.
//     try {
//       poses = await detector.estimatePoses(
//           camera.video,
//           {maxPoses: params.STATE.modelConfig.maxPoses, flipHorizontal: false});
//     } catch (error) {
//       detector.dispose();
//       detector = null;
//       alert(error);
//     }
//   }

//   camera.drawCtx();

//   // The null check makes sure the UI is not in the middle of changing to a
//   // different model. If during model change, the result is from an old model,
//   // which shouldn't be rendered.
//   if (poses && poses.length > 0 && !params.STATE.isModelChanged) {
//     camera.drawResults(poses);

//   }
// }

// async function renderPrediction() {

//   if (!params.STATE.isModelChanged) {
//     await renderResult();
//   }

//   rafId = requestAnimationFrame(renderPrediction);
// };

// async function app() {

//   camera = await Camera.setupCamera(params.STATE.camera);

//   await setBackendAndEnvFlags(params.STATE.flags, params.STATE.backend);

//   detector = await createDetector();

//   renderPrediction();
// };

// app();
