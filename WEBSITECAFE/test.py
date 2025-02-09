from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.chrome.service import Service
import time

# Pastikan ChromeDriver terinstal dan terdeteksi
driver = webdriver.Chrome()
driver.get("http://localhost/WEBSITECAFE/login.php")

# Interaksi dengan elemen
username = driver.find_element(By.ID, "username")
password = driver.find_element(By.ID, "password")
username.send_keys("testuser")
password.send_keys("testpassword")
driver.find_element(By.XPATH, "//button").click()

# Tunggu dan cek
time.sleep(30)  # Tunggu proses login selesai
assert "Selamat Datang, testuser" in driver.page_source
driver.quit()
